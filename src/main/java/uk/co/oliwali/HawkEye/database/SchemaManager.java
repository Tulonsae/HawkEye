package uk.co.oliwali.HawkEye.database;

import java.sql.DatabaseMetaData;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

import uk.co.oliwali.HawkEye.database.JDCConnection;
import uk.co.oliwali.HawkEye.util.Config;
import uk.co.oliwali.HawkEye.util.Util;

/**
 * Schema manager for HawkEye.
 * @author Tulonsae
 */
public class SchemaManager {

    // schema current version
    private static final String curVersion = "1.0";

    // base table names - add prefix to get the db table name
    private static String schemaVersionTbl = Config.DbPrefix + "schema_version";
    private static String schemaTablesTbl = Config.DbPrefix + "schema_tables";

    ConnectionManager connections;

    /**
     * Schema tables.
     * @return true on succes, false on failure
     */
    protected boolean checkSchemaTables(ConnectionManager connectionManager) {

        JDCConnection conn = null;
        Statement sqlCmd = null;
        ResultSet rs = null;

        connections = connectionManager;

        try {
            conn = getConnection();
            sqlCmd = conn.createStatement();
            DatabaseMetaData dbm = conn.getMetaData();

            // check schema version table
            if (!JDBCUtil.tableExists(dbm, schemaVersionTbl)) {
                Util.info("Table [" + schemaVersionTbl + "] not found, creating...");

                sqlCmd.execute("CREATE TABLE IF NOT EXISTS `" + schemaVersionTbl + "` (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` varchar(25) NOT NULL UNIQUE KEY, `description` varchar(255) NOT NULL, `row_created` datetime NOT NULL, `row_updated` datetime NOT NULL);");
            }

            // check schema tables table
            if (!JDBCUtil.tableExists(dbm, schemaTablesTbl)) {
                Util.info("Table [" + schemaTablesTbl + "] not found, creating...");

                sqlCmd.execute("CREATE TABLE IF NOT EXISTS `" + schemaTablesTbl + "` (`version_id` int(11) NOT NULL, `prefix_name` varchar(25), `table_name` varchar(55) NOT NULL, `description` varchar(255) NOT NULL, `row_created` datetime NOT NULL, `row_updated` datetime NOT NULL, KEY `table_index` (`prefix_name`, `table_name`), FOREIGN KEY `id` (`version_id`) references `schema_version` (`id`) );");
            }

            // check schema version
            rs = sqlCmd.executeQuery("SELECT count(*) from " + schemaVersionTbl + " ;");
            rs.first();	// todo - if false, then an internal err
            if (rs.getInt(1) == 0) {
                // version table empty, initialize to current version
                // this code will change each time the schema is changed
                // current version = 1.0

                // load schema version table
                String description = "Version 1.0 schema = HawkEye 1.05b schema plus these schema version tables";
                sqlCmd.execute("INSERT INTO " + schemaVersionTbl + " (name, description, row_created, row_updated) VALUES ('" + curVersion + "', '" + description + "', NOW(), NOW());");
                rs = sqlCmd.executeQuery("SELECT id from " + schemaVersionTbl + " WHERE name = '" + curVersion + "';");
                rs.first();	// todo - if false, then an internal err
                int versionId = rs.getInt("id");

                // load schema tables table
                // check for previous (oliwali) or new install
                String dataTable;
                String playerTable;
                String worldTable;
                String prefix;
                if (JDBCUtil.tableExists(dbm, Config.DbHawkEyeTable)) {
                    // oliwali install
                    prefix = "";
                    dataTable = Config.DbHawkEyeTable;
                    playerTable = Config.DbPlayerTable;
                    worldTable = Config.DbWorldTable;
                } else {
                    // new install
                    prefix = Config.DbPrefix;
                    dataTable = "hawkeye";
                    playerTable = "players";
                    worldTable = "worlds";
                }
                sqlCmd.execute("INSERT INTO " + schemaTablesTbl + " (version_id, prefix_name, table_name, description, row_created, row_updated) VALUES (" + versionId + ", '" + prefix + "', '" + dataTable + "', 'Version " + curVersion + " - main data table containing all recorded actions', NOW(), NOW());");
                sqlCmd.execute("INSERT INTO " + schemaTablesTbl + " (version_id, prefix_name, table_name, description, row_created, row_updated) VALUES (" + versionId + ", '" + prefix + "', '" + playerTable + "', 'Version " + curVersion + " - player data table containing all recorded player names', NOW(), NOW());");
                sqlCmd.execute("INSERT INTO " + schemaTablesTbl + " (version_id, prefix_name, table_name, description, row_created, row_updated) VALUES (" + versionId + ", '" + prefix + "', '" + worldTable + "', 'Version " + curVersion + " - world data table containing all recorded world names', NOW(), NOW());");
            }
            // once there is another version, we'll need an else here
            // to check for whether we have the current version of not

        } catch (SQLException e) {
            Util.severe("Error checking Hawkeye schema tables: " + e);
            return false;
        } finally {
            try {
                if (sqlCmd != null) {
                    sqlCmd.close();
                }
                conn.close();
            } catch (SQLException e) {
                Util.severe("Unable to close SQL connection: " + e);
            }
        }

        return true;
    }
    
    /**
     * Returns a database connection from the pool
     * @return {JDCConnection}
     */
    public JDCConnection getConnection() {
        try {
            return connections.getConnection();
        } catch (final SQLException ex) {
            Util.severe("Error whilst attempting to get connection: " + ex);
            return null;
        }
    }
}

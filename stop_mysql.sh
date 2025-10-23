#!/bin/bash
# A script to stop the MySQL service and verify its status.

# --- Configuration ---
# The name of the MySQL service. This can be 'mysql', 'mysqld', or 'mariadb'
# depending on your system and installation. 'mysql' is the most common.
SERVICE_NAME="mysql"
# ---

echo "Attempting to stop the $SERVICE_NAME service..."

# Stop the service using systemctl.
# The 'sudo' command is used to run this with root privileges.
sudo systemctl stop $SERVICE_NAME

# Check the exit code of the last command ($?)
# A code of 0 means the command was successful.
if [ $? -eq 0 ]; then
    echo "✅ Successfully sent stop command to $SERVICE_NAME."
else
    echo "❌ Failed to send stop command. Please check for errors above."
    # Exit the script with an error code
    exit 1
fi

# Verify the final status of the service
echo "" # Add a blank line for readability
echo "Verifying service status..."
CURRENT_STATUS=$(systemctl is-active $SERVICE_NAME)

if [ "$CURRENT_STATUS" = "inactive" ] || [ "$CURRENT_STATUS" = "failed" ]; then
    echo "✅ Confirmed: The $SERVICE_NAME service is now '$CURRENT_STATUS'."
else
    echo "⚠️ Warning: The $SERVICE_NAME service is still '$CURRENT_STATUS'."
fi

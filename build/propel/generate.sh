#!/bin/bash

#set variables
CURRENT_DIR="`dirname \"$0\"`"/
ROOT_DIR=${CURRRENT_DIR}../..
CONFIG_DIR=${CURRENT_DIR}../../config/propel
DB_NAME=default
NAMESPACE=App\\Propel\\

#Clean-up old propel classes
rm -rf ${ROOT_DIR}/app/Propel/

#Create Database schema
echo Create Database schema
${ROOT_DIR}/vendor/bin/propel reverse --config-dir=${CONFIG_DIR}/ --output-dir=${CONFIG_DIR} --database-name=${DB_NAME} --schema-name=schema_auto

#Add database namespace for generated classes
echo Add database namespace for generated classes
php ${CURRENT_DIR}/replace_in_file.php "database name=\"${DB_NAME}\" defaultIdMethod=\"native\" defaultPhpNamingMethod=\"underscore\">" "<database name=\"${DB_NAME}\" defaultIdMethod=\"native\" defaultPhpNamingMethod=\"underscore\" namespace=\"${NAMESPACE}\">" "${CONFIG_DIR}/schema_auto.xml"

#Move file with the new name
echo Move file with the new name
mv ${CONFIG_DIR}/schema_auto.xml ${CONFIG_DIR}/schema.xml

#Create all model classes
echo Create all model classes
${ROOT_DIR}/vendor/bin/propel model:build --config-dir=${CONFIG_DIR}/ --output-dir=${ROOT_DIR}/ --schema-dir=${CONFIG_DIR}/
echo Model classes generated


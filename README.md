Like I said, I'm not a very good task planner.
My idea was to break down the excel table into separate cells and validate each cell with a separate validator. After each cell went through a rudimentary validation, the entire table had to be validated as required. At the moment, only a rudimentary validation of cells was implemented. All of this is implemented asynchronously through rabbitmq and docker.
Now you can only import a file via cli.



How to run app: <br>
<code>bin/build.sh</code> <br>
<code>bin/up.sh</code> <br>
<code>bin/composer.sh install</code> <br>
<code>bin/console.sh doctrine:migrations:migrate</code> <br>
<code>bin/console.sh "app:import %filename%"</code> <br>
Then you should run two rabbitmq consumers: <br>
<code>bin/console.sh "messenger:consume import_process"</code> <br>
<code>bin/console.sh "messenger:consume table_content_importer"</code> <br>
You can monitor rabbitmq queues stats at <code>localhost:15672 </code> <br>

After the import and validation of the document is complete, you can check the import status in the database: app_import_process table, "status" column. Status will contain the number corresponding to the constant from src/Entity/ImportProcess.php
More detailed validation reports for each cell can be found in the app_table_data table. 

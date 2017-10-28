Note about JSON encoding :
Support was added to let PHP apps post messages to Kafka through Confluent REST proxy.
CAUTION : binary data is not really supported -- better off to avoid fixed and bytes types.

encode_json.php demonstrates usage of class AvroJSONWriter.
read_avr_mk_json.php can be used to test it, along with e.g. avro-tools and sample schemas.
E.g. :
1) make some binary file
java -jar avro-tools-1.8.2.jar random --codec null --count 10 --schema-file schem.avsc > schem.avr
2) have PHP read avro file and produce one line of avro-JSON for each datum read
php read_avr_mk_json.php schem.avr | grep "^{" > schem.json
3) check the JSON produced can be read back by Avro 
java -jar avro-tools-1.8.2.jar jsontofrag --schema-file schem.avsc schem.json

Some sample schemas are also provided. They were used to quickly test JSON production.


#!/usr/bin/env php
<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('../lib/avro.php');

$file_name = $argv[1];
echo "reading $file_name ...\n";
$data_reader = AvroDataIO::open_file($file_name);
$json_schema = $data_reader->json_schema();
$writers_schema = AvroSchema::parse($json_schema);
$jwriter = new AvroJSONWriter($writers_schema);
foreach ($data_reader->data() as $datum){
  echo var_export($datum, true) . "\n";
  $jwriter->write($datum);
  echo $jwriter->string() . "\n";
  $jwriter->reset();
}
$data_reader->close();


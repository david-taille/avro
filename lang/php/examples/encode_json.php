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

// Write and read a data file

$writers_schema_json = <<<_JSON
{"name":"member",
 "type":"record",
 "fields":[{"name":"member_id", "type":"int"},
           {"name":"age", "type":["null","int"]},
           {"name":"member_name", "type":"string"},
           {"name":"wages", "type":"float"},
           {"name":"children", "type":{"type":"array", "items":"string"}},
           {"name":"sex", "type":{"type":"enum", "symbols":["Male", "Female"], "namespace":"x.y", "name":"Sex"}},
		{"name":"clone",
		 "type":["null",{
                        "name":"Clone",
			"type":"record",
		 	"fields":[{"name":"member_id", "type":"int"},
			   	{"name":"age", "type":["null","int"]},
				   {"name":"member_name", "type":"string"},
				   {"name":"wages", "type":"float"},
				   {"name":"children", "type":{"type":"array", "items":"string"}},
				   {"name":"sex", "type":"x.y.Sex"}
				]
		}]}
]}
_JSON;

$jose = array('member_id' => 1392, 'member_name' => 'Jose', "age"=>null, "wages"=>12.23, "children"=>[], "sex"=>"Male", "clone"=>null);
$maria = array('member_id' => 1642, 'member_name' => 'Maria', "age"=>23, "wages"=>-45.123, "children"=>["a", "b"], "sex"=>"Female", "clone"=>null);
$dave = array('member_id' => 1642, 'member_name' => 'Maria', "age"=>23, "wages"=>-45.123, "children"=>["a"], "sex"=>"Male", "clone"=>$maria);
$data = array($jose, $maria, $dave);

// Create a datum writer object
$writers_schema = AvroSchema::parse($writers_schema_json);
$writer = new AvroJSONWriter($writers_schema);
foreach ($data as $datum)
   $writer->write($datum);

$s = $writer->string();

echo "$s\n";


<?php
/**
 * World of Warcraft DBC Library
 * Copyright (c) 2011 Tim Kurvers <http://www.moonsphere.net>
 *
 * This library allows creation, reading and export of World of Warcraft's
 * client-side database files. These so-called DBCs store information
 * required by the client to operate successfully and can be extracted
 * from the MPQ archives of the actual game client.
 *
 * The contents of this file are subject to the MIT License, under which
 * this library is licensed. See the LICENSE file for the full license.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author	Tim Kurvers <tim@moonsphere.net>
 */

namespace Timkurvers\WowDbcPhp\Exporters;

use Timkurvers\WowDbcPhp\IDBCExporter;
use Timkurvers\WowDbcPhp\DBC;
use Timkurvers\WowDbcPhp\DBCException;
use Timkurvers\WowDbcPhp\DBCMap;

/**
 * XML Exporter
 */
class DBCXMLExporter implements IDBCExporter {

	/**
	 * Exports given DBC in XML format to given target (defaults to output stream)
	 */
	public function export(DBC $dbc, $target=self::OUTPUT) {
		$map = $dbc->getMap();
		if($map === null) {
			throw new DBCException(self::NO_MAP);
			return;
		}

		$dom = new \DOMDocument('1.0');
		$dom->formatOutput = true;

		$edbc = $dom->appendChild($dom->createElement('dbc'));
		$efields = $edbc->appendChild($dom->createElement('fields'));
		$erecords = $edbc->appendChild($dom->createElement('records'));

		$fields = $map->getFields();
		foreach($fields as $name=>$rule) {
			$count = max($rule & 0xFF, 1);
			if($rule & DBCMap::UINT_MASK) {
				$type = 'uint';
			}else if($rule & DBCMap::INT_MASK) {
				$type = 'int';
			}else if($rule & DBCMap::FLOAT_MASK) {
				$type = 'float';
			}else if($rule & DBCMap::STRING_MASK || $rule & DBCMap::STRING_LOC_MASK) {
				$type = 'string';
			}
			for($i=1; $i<=$count; $i++) {
				$suffix = ($count > 1) ? $i : '';
				$efields->appendChild($dom->createElement($name.$suffix, $type));
			}
		}
		foreach($dbc as $i=>$record) {
			$pairs = $record->extract();
			$erecord = $erecords->appendChild($dom->createElement('record'));
			foreach($pairs as $field=>$value) {
				$attr = $dom->createAttribute($field);
				$attr->value = $value;
				$erecord->appendChild($attr);
			}
		}

		$data = $dom->saveXML();

		file_put_contents($target, $data);
	}

}

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

use Timkurvers\WowDbcPhp\DBC;
use Timkurvers\WowDbcPhp\DBCMap;
use Timkurvers\WowDbcPhp\Exporters\DBCXMLExporter;

require('bootstrap.php');

/**
 * This example shows how to export a DBC-file to XML format
 */

// Open given DBC and given map (ensure read-access on both)
$dbc = new DBC('./dbcs/Sample.dbc', DBCMap::fromINI('./maps/Sample.ini'));

// When exporting to the standard PHP output, ensure the browser expects an XML-document
header('Content-Type: application/xml');

// Set up a new XML exporter
$xml = new DBCXMLExporter();

// And instruct it to export the given DBC (ensure the DBC has an attached map)
$xml->export($dbc);

// Alternatively supports exporting to a file by providing a second argument
$xml->export($dbc, './export/sample.xml');

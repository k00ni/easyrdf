<?php

/**
 * EasyRdf
 *
 * LICENSE
 *
 * Copyright (c) 2009-2010 Nicholas J Humfrey.  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. The name of the author 'Nicholas J Humfrey" may be used to endorse or
 *    promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2010 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @version    $Id$
 */

require_once dirname(dirname(dirname(__FILE__))).
             DIRECTORY_SEPARATOR.'TestHelper.php';

class EasyRdf_Serialiser_RdfXmlTest extends EasyRdf_TestCase
{
    protected $_serialiser = null;
    protected $_graph = null;

    public function setUp()
    {
        $this->_graph = new EasyRdf_Graph();
        $this->_serialiser = new EasyRdf_Serialiser_RdfXml();
    }

    function testSerialiseRdfXml()
    {
        $joe = $this->_graph->resource('http://www.example.com/joe#me');
        $joe->set('foaf:name', 'Joe Bloggs');
        $joe->set(
            'foaf:homepage',
            $this->_graph->resource('http://www.example.com/joe/')
        );

        $this->assertEquals(
			"<rdf:RDF xmlns:cc=\"http://creativecommons.org/ns#\" xmlns:dc=\"http://purl.org/dc/terms/\" xmlns:dc11=\"http://purl.org/dc/elements/1.1/\" xmlns:doap=\"http://usefulinc.com/ns/doap#\" xmlns:exif=\"http://www.w3.org/2003/12/exif/ns#\" xmlns:foaf=\"http://xmlns.com/foaf/0.1/\" xmlns:http=\"http://www.w3.org/2006/http#\" xmlns:owl=\"http://www.w3.org/2002/07/owl#\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:rdfs=\"http://www.w3.org/2000/01/rdf-schema#\" xmlns:rss=\"http://purl.org/rss/1.0/\" xmlns:sioc=\"http://rdfs.org/sioc/ns#\" xmlns:skos=\"http://www.w3.org/2004/02/skos/core#\" xmlns:synd=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:wot=\"http://xmlns.com/wot/0.1/\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml/vocab#\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema#\" >\n".
			" <rdf:Description rdf:about=\"http://www.example.com/joe#me\">\n".
				"	<foaf:name>Joe Bloggs</foaf:name>\n".
				"	<foaf:homepage rdf:resource='http://www.example.com/joe/'/>\n".
			"</rdf:Description>\n\n".
			"<rdf:Description rdf:about=\"http://www.example.com/joe/\">\n".
			"</rdf:Description>\n\n" .
			"</rdf:RDF>",
            $this->_serialiser->serialise($this->_graph, 'rdfxml')
        );
    }

    function testSerialiseUnsupportedFormat()
    {
        $this->setExpectedException('EasyRdf_Exception');
        $rdf = $this->_serialiser->serialise(
            $this->_graph, 'unsupportedformat'
        );
    }
}
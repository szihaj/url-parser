<?php

use PHPUnit\Framework\TestCase;

class UrlParserTest extends TestCase
{
    /** @test */
    function it_parses_full_url_with_query_string()
    {
        $url = 'https://google.com/index.php?t=teszt';

        $parser = new UrlParser($url);

        $parser->addToQuery('teszt2', 'teszt2 value');

        $this->assertEquals(
            'https://google.com/index.php?t=teszt&teszt2=teszt2+value',
            $parser->url()
        );
    }

    /** @test */
    function it_parses_url_without_protocol()
    {
        $parser = new UrlParser('pintofsource.com/join.php?t=a-b-c');

        $this->assertEquals(
            'pintofsource.com/join.php?t=a-b-c',
            $parser->url()
        );
    }

    /** @test */
    function it_parses_url_without_protocol_while_adding_to_the_query_string()
    {
        $parser = new UrlParser('pintofsource.com/join.php?t=a-b-c');

        $parser->addToQuery('some-new-key', 'some-new-value');
        $parser->addToQuery('hibakod', '7');

        $this->assertEquals(
            'pintofsource.com/join.php?t=a-b-c&some-new-key=some-new-value&hibakod=7',
            $parser->url()
        );
    }

    /** @test */
    function it_adds_the_query_string_if_it_doesnt_exist()
    {        
        $parser = new UrlParser('http://pintofsource.com/join.php');

        $parser->addToQuery('some-key', 'some-value');

        $this->assertEquals(
            'http://pintofsource.com/join.php?some-key=some-value',
            $parser->url()
        );
    }
}
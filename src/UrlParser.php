<?php

class UrlParser
{
    protected $url;
    
    protected $query = [];

    protected $pieces;
    
    public function __construct($url)
    {
        $this->url = $url;
        
        $this->parseQueryString();
    }
    
    public function parseQueryString()
    {
        $this->pieces = parse_url($this->url);
        
        if (isset($this->pieces['query'])) {
            parse_str($this->pieces['query'], $this->query);
        }
    }
    
    public function addToQuery($name, $value)
    {
        $this->query[$name] = $value;
    }
    
    public function url()
    {
        $this->pieces['query'] = http_build_query($this->query);

        return $this->buildUrl($this->pieces);
    }

    /**
     * NobleUplift @ https://stackoverflow.com/questions/4354904/php-parse-url-reverse-parsed-url
     * @param  array  $parts
     * @return string The url.
     */
    public function buildUrl($parts)
    {
        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') . 
            ((isset($parts['user']) || isset($parts['host'])) ? '//' : '') . 
            (isset($parts['user']) ? "{$parts['user']}" : '') . 
            (isset($parts['pass']) ? ":{$parts['pass']}" : '') . 
            (isset($parts['user']) ? '@' : '') . 
            (isset($parts['host']) ? "{$parts['host']}" : '') . 
            (isset($parts['port']) ? ":{$parts['port']}" : '') . 
            (isset($parts['path']) ? "{$parts['path']}" : '') . 
            (isset($parts['query']) ? "?{$parts['query']}" : '') . 
            (isset($parts['fragment']) ? "#{$parts['fragment']}" : '');
    }
    
    public function getWithPath()
    {
        $parts = $this->pieces;

        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') .
            '//' .
            (isset($parts['host']) ? "{$parts['host']}" : '') .
            (isset($parts['path']) ? "{$parts['path']}" : '');
    }
}


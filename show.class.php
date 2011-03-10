<?php

class Show
{
	
	protected $_details = array();

	public function __construct( $fields )
	{
		$this->parse($fields);
	}
	
	public function __get( $k )
	{
		return $this->_details[$k];
	}
	
	public function __set( $k, $v )
	{
		$this->_details[$k] = $v;
	}
	
	public function __toString()
	{
		return ( $this->is_film ? '[FILM] ' : '' ) . $this->title .  ( $this->year ? ' (' . $this->year . ')' : '' ) . "\n";
	}
	
	protected function parse( $f )
	{
		$this->title = $f[0];
		$this->sub_title = $f[1];
		$this->episode = $f[2];
		$this->year = $f[3];
		$this->director = $f[4];
		$this->cast = array();
		$this->cast_string = $f[5];
		$this->is_premiere = $f[6];
		$this->is_film = $f[7];
		$this->is_repeat = $f[8];
		$this->is_subtitled = $f[9];
		$this->is_widescreen = $f[10];
		$this->is_new_series = $f[11];
		$this->is_deaf_signed = $f[12];
		$this->is_black_and_white = $f[13];
		$this->film_rating = $f[14];
		$this->film_certificate = $f[15];
		$this->genre = $f[16];
		$this->description = $f[17];
		$this->is_radio_times_choice = $f[18];
		$this->date = $f[19];
		$this->start_time = $f[20];
		$this->end_time = $f[21];
		$this->duration = $f[22];
		
		$this->parse_cast();
		$this->force_boolean();
	}
	
	protected function parse_cast()
	{
		$cast = array();
		foreach ( explode("|", $this->cast_string) as $cs)
		{
			$parts = explode("*", $cs);
			if (count($parts) < 2) { continue; }
			$cast[$parts[0]] = $parts[1];
		}
		
		$this->cast = $cast;
		
		unset($this->_details['cast_string']);
	}
	
	protected function force_boolean()
	{
		foreach ($this->_details as $k => $v)
		{
			if ( substr($k, 0, 3) == 'is_' )
			{
				if ( $v === 'true')
				{
					$b = true;
				}
				else if ( $v === 'false' )
				{
					$b = false;
				}
				else
				{
					throw new exception('Invalid Boolean Type');
				}
				
				$this->_details[$k] = $b;
			}
		}
	}

}
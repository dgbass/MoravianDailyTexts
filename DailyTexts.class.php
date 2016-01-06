<?php

Class DailyTexts{

	/**
	 * Property declarations.
	 */
	protected $date;             // The date 
	protected $csv_parse;		// the parsed data as an array
	public $watchword;			//the watchword for the date
	public $doctrine;			// the doctrine for the date
	public $filename;
	/*
	   Constructor
	 */
	public function __construct($date){
		$condate = explode('.', $date);
    	$year=trim($condate[2]);
		$this->date = $date;
		$this->filename="Losungen_" . $year . ".csv";
		$this->csv_parse=$this->init();
	}

	/**
	  get the watchword for the specific day
	  from the old Testament of the Bible
	 **/
	public function getWatchword(){
		foreach ($this->csv_parse as $line) {
			$dateText=	 $line[0];
			$watchwReference=$line[3];
			$watchwVerse=$line[4];
			$dateTextwW= preg_replace('/\0/','',$dateText);

			if(strcmp(trim($dateTextwW),trim($this->date))==0){
				$encodedVerse=utf8_encode($watchwVerse);
				$encodedReference=utf8_encode($watchwReference);
				$this->watchword=$encodedReference . "  - " . $encodedVerse;
				break;
			}

		}
		return $this->watchword;
	}

	/**
	  get Doctrine for a specific date
	  from the New testament of the Bible
	 **/
	public function getDoctrine(){

		foreach ($this->csv_parse as $line) {
			$dateText=	 $line[0];
			$doctrineReference=$line[5];
			$doctrineVerse=$line[6];
			$dateTextwW= preg_replace('/\0/','',$dateText);
			if(strcmp(trim($dateTextwW),trim($this->date))==0){
				$encodedVerse2=utf8_encode($doctrineVerse);
				$encodedReference2=utf8_encode($doctrineReference);
				$this->doctrine=$encodedReference2 . "  - " . $encodedVerse2;
				break;
			}
		}	
		return $this->doctrine;
	}

	public function init(){
		// parse csv file
		$csvFile = file($this->filename,FILE_SKIP_EMPTY_LINES);
		$data = [];
		foreach ($csvFile as $line) {
			$data[] = str_getcsv($line,"\t");
		}
		return $data;
	}

 public function getYear($pdate) {
    $condate = DateTime::createFromFormat("Y-m-d", $pdate);
    return $condate->format("Y");
}

}

?>

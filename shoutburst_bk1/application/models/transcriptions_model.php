<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transcriptions_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_transcription
	 */
	public function get_transcription($transcription_id, $comp_id, $transcriber)
	{
		$query = array();
		if ( $transcriber == 1){
			$sql = "SELECT s.recording, s.date_time, t.* 
					FROM surveys s
					RIGHT JOIN transcriptions t ON s.sur_id = t.sur_id
					WHERE s.comp_id = $comp_id AND s.processed = 1 AND t.transcription_id = $transcription_id";
			$query = $this->db->query($sql)->result_array();
		}		
		return $query;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	insert_transcription
	 */
	public function insert_transcription( $sur_id )
	{
		$this->db->query("INSERT INTO transcriptions (sur_id) VALUES($sur_id)" );
		return $this->db->insert_id();
	}
	
	public function insert_transcriptions($insert_transcription)
	{
		$this->db->insert('transcriptions', $insert_transcription);
		return $this->db->insert_id();
	}
	
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_transcriptions
	 */
	function get_transcriptions($comp_id, $transcriber)
	{
		$query = array();
		if ( $transcriber == 1)
		{
			$sql = "SELECT s.*, s.date_time,t.transcription_id, t.transcriptions_text, t.sentiment_score, t.gender 
					FROM surveys s
					LEFT JOIN transcriptions t ON s.sur_id = t.sur_id
					WHERE s.comp_id = $comp_id AND s.processed = 1 AND downloaded=1 AND (LENGTH(transcriptions_text) < 5 OR transcriptions_text IS NULL)";

			$query = $this->db->query($sql)->result();			
		}		
		return $query;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	update_transcription
	 */
	public function update_transcription($update_transcription)
	{
		$transcription_id = $update_transcription['transcription_id'];
		$this->db->where('transcription_id', $transcription_id);
		if ($this->db->update('transcriptions', $update_transcription) ){
			return true;
		} else {
			return false;
		}
	}
}
?>

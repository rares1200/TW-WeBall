<?php

include('models/admin_model.php');
include('config.php');

$GLOBALS['conn'] = $db;

function get_all_competitions(){
	return getAllCompetitions($GLOBALS['conn']);	
}

function get_match_winner($id_comp,$faza){
	return get_winner($GLOBALS['conn'],$id_comp,$faza);	
}

function show_groups($id_comp){
	
	return showGroups($GLOBALS['conn'],$id_comp);
	
}

function show_knockout($id_comp){
	
	return showKnockout($GLOBALS['conn'],$id_comp);	
	
}

function update_groups($id_comp){
	if(updateCompetitionGroups($GLOBALS['conn'],$id_comp)){
		return "Grupe actualizate cu succes";
	}else{
		return "Grupele nu au fost actualizate";	
	}
}

function update_knockout($id_comp){
	
	if(updateCompetitionKnockout($GLOBALS['conn'],$id_comp)){
		return "Competitie actualizata cu succes";	
	}else{
		return "Competitia nu a fost actualizata";	
	}
	
}

function get_optimi_comp($id_comp){

	return get_optimi($GLOBALS['conn'],$id_comp);	

}

function get_sferturi_comp($id_comp){

	return get_sferturi($GLOBALS['conn'],$id_comp);	

}

function get_sf_comp($id_comp){

	return get_semifinale($GLOBALS['conn'],$id_comp);	

}

function get_finala_comp($id_comp){

	return get_finala($GLOBALS['conn'],$id_comp);	

}

function get_matches_from_group($id_comp,$group){
	
	return getMatchesFromGroup($GLOBALS['conn'],$id_comp,$group);
		
}

function update_group($id_comp,$grupa){

	if(updateGroup($GLOBALS['conn'],$id_comp,$grupa)){
		return "Grupa actualizata cu succes";	
	}else{
		return "Grupa nu a fost actualizata";	
	}
}

function get_all_sports(){

	return get_sporturi($GLOBALS['conn']);	
	
}

function get_comp_ID(){

	return getCompetitionId($GLOBALS['conn']);
	
}

function get_teams_count($id_sport){

	return getTeamsCount($GLOBALS['conn'],$id_sport);
	
}

function get_all_teams($name,$id_sport){

	return getAllTeams($GLOBALS['conn'],$name,$id_sport);
	
}

function get_team_ID($name){
	
	return getIdEchipa($GLOBALS['conn'],$name);	
}

function create_competition($nume_competitie,$nr_echipe,$id_sport,$nr_echipe_calif){
	
	if(createCompetition($GLOBALS['conn'],$nume_competitie,$nr_echipe,$id_sport,$nr_echipe_calif)){
		return "Competitie creata cu succes!";
	}else{
		return "Competitia nu a fost creata!";		
	}

}

function add_event($id_meci,$echipa,$event,$jucator,$minut,$echipa1,$echipa2){
	
	if(addEvent($GLOBALS['conn'],$id_meci,$echipa,$event,$jucator,$minut,$echipa1,$echipa2)){
		return "Eveniment adaugat cu succes!";	
	}
	else{
		return "Evenimentul nu a fost adaugat";	
	}
}

function update_score($scor1,$scor2,$id_meci){
	
	if(updateScore($GLOBALS['conn'],$scor1,$scor2,$id_meci)){
		return "Scorul a fost actualizat cu succes!";	
	}else{
		return "Scorul nu a fost actualizat";
	}
	
}

function delete_event($event_id,$id_meci,$echipa1,$echipa2){

	if(deleteEvent($GLOBALS['conn'],$event_id,$id_meci,$echipa1,$echipa2)){
		return "Evenimentul a fost sters";
	}else{
		return "Evenimentul nu a fost sters";	
	} 
	
}
 
function update_date($id_meci,$echipa1,$echipa2,$data){
	
	if(updateDate($GLOBALS['conn'],$id_meci,$echipa1,$echipa2,$data)){
		return "Data actualizata cu succes";
	}else{
		return "Data nu a fost actualizata";	 
	}
}

function get_table_match_header($id_meci){
	
	return get_table_header($GLOBALS['conn'],$id_meci);	
}

function get_match_events($id_meci,$e1,$e2){

	return get_events($GLOBALS['conn'],$id_meci,$e1,$e2);	
	
}

function get_date_match($id_meci){
	
	return get_match_date($GLOBALS['conn'],$id_meci);	
	
}

function create_poll($id_meci,$q,$q1,$q2,$q3){

	if(createPoll($id_meci,$q,$q1,$q2,$q3)){
		return "Poll creat cu succes!";
	}else{
		return "Poll-ul nu a fost creat!";	
	}
	
}

?>
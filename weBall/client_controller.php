<?
include("config.php");
include("models/client_model.php");


	function get_competitions($page){

		return getCompetitions($page);		
		
	}
	
	function show_groups($id_comp){
		return showGroups($id_comp);
	}
	
	function show_knockout($id_comp){
		return showKnockout($id_comp);
	}
	
	function get_matches_from_group($id_comp,$grupa){
		return getMatchesFromGroup($id_comp,$grupa);	
	}
	
	function get_match_header($id_meci){
		return getTableHeader($id_meci);	
	}
	
	function get_events($id_meci,$e1,$e2){
		return getEvents($id_meci,$e1,$e2);	
	}
	
	function get_match_date($id_meci){
		return getMatchDate($id_meci);	
	}
	
	function add_comment($id_meci,$user,$comment){
		if(addComment($id_meci,$user,$comment)){
			return "Comentariul a fost adaugat";	
		}else{
			return "Comentariul nu a fost adaugat";	
		}
	}
	
	function get_comments($id_meci){
		return getComments($id_meci);
	}

	function get_match_search($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2,$page){
	
		return searchMatch($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2,$page);
		
	}
	
	function get_match_count($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2){
	
		return searchCount($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2);
		
	}
	
	function get_competition_count(){
		return getCountCompetitions();
	}
	
	function show_groups_html($id_comp){
		return showGroupsHTML($id_comp);	
	}
	
	function get_poll($id_meci){
		return getPoll($id_meci);	
	}

	function vote($answer,$id_meci){
		return poolVote($answer,$id_meci);	
	}
	
	function get_poll_results_A($id_meci){
		return getPoolResultsA($id_meci);	
	}
	
	function get_poll_results_B($id_meci){
		return getPoolResultsB($id_meci);	
	}
	
	function get_poll_results_C($id_meci){
		return getPoolResultsC($id_meci);	
	}
	
	function get_poll_results($id_meci){
		return getPollResults($id_meci);	
	}
	
	function forgot_pass($email){
		return forgotPass($email);	
	}
	
	
	function get_user_competitions($user){

		return getUserCompetitions($user);		
		
	}
	
	function show_groups_user($id_comp){
		return showGroupsUser($id_comp);
	}
	
	function show_knockout_user($id_comp){
		return showKnockoutUser($id_comp);
	}
	
	function get_matches_from_group_user($id_comp,$grupa){
		return getMatchesFromGroupUser($id_comp,$grupa);	
	}
	
	function update_competition_groups_user($id_comp){
		return updateCompetitionGroupsUser($id_comp);	
	}
	
	function update_competition_knockout_user($id_comp){
		return updateCompetitionKnockoutUser($id_comp);	
	}
	
	function get_comp_ID_user(){
		return getCompIDUser();
	}
	
	function update_group_user($id_comp,$group){
		return updateGroupUser($id_comp,$group);	
	}
	
	function get_search_comp($comp_name,$type){
		return getSearchCompetition($comp_name,$type);	
	}
?>
<?php
class Query{
	
		//Funci�n que comienza una transacci�n.
		function b_trans($db) {
			$query = "BEGIN TRANSACTION";
			$result = $db->sql_query ( $query );
			return ($result);
		}
		
		//Funci�n que realiza el commit de una transacci�n.
		function c_trans($db) {
			$query = "COMMIT TRANSACTION";
			$result = $db->sql_query ( $query );
			return ($result);
		}
		
		//Funci�n que realiza el rollback de una transacci�n.
		function r_trans($db) {
			$query = "ROLLBACK TRANSACTION";
			$result = $db->sql_query ( $query );
			return ($result);
		}
}
?>
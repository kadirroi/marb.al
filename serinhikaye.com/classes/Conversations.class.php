<?php

include_once ("classes/Conversation.class.php");
include_once("classes/DBConnector.class.php");

class Conversations
{
	
	var $conversationsInfos = array ();
	
	public function Conversations($ary)
	{
		global $conversationsInfos;

		$conversationsInfos["Pour Qui"]= $ary[0];
	}

	public function ConversationsToHTML()
	{
		global $conversationsInfos;
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();
		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		if ($connection->connect_error)
			echo "Database bağlantı hatası";
		else
		{
			$query = "SELECT * FROM conversations WHERE (user1=\"".$conversationsInfos["Pour Qui"]."\" OR user2=\"".$conversationsInfos["Pour Qui"]."\") ORDER BY lastDate DESC ";
			$results = $connection->query($query);
			if ($results->num_rows==0)
			{
				echo "<div style=\"margin:2%;background-color:#e6e6e6;color:#6e6e6e;font-size:18px;font-family: Verdana,Geneva,sans-serif;\">";
					echo "Henüz mesajlaşmamışsınz.";
				echo "</div>";
			}
			else
			{
				while ($curResult = $results->fetch_assoc())
				{
					if ($curResult["user1"] == $conversationsInfos["Pour Qui"])
						$other = $curResult["user2"];
					else
						$other = $curResult["user1"];

					$ary = array($other,$conversationsInfos["Pour Qui"],$conversationsInfos["Pour Qui"]);
					$myConversation = new Conversation($ary);
					$myConversation->ConversationToHTML();
				}
			}
			$connection->close();
		}	
	}

}

?>

<?php
include 'db/connect.php';
include 'includes/header.php';

$sql = "SELECT
			categories.cat_id,
			categories.cat_name,
			categories.cat_description,
			COUNT(topics.topic_id) AS topics
		FROM
			categories
		LEFT JOIN
			topics
		ON
			topics.topic_id = categories.cat_id
		GROUP BY
			categories.cat_name, categories.cat_description, categories.cat_id";

$result = mysql_query($sql);

if(!$result)
{
	echo 'The categories could not be displayed, please try again later.';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'No categories defined yet.';
	}
	else
	{
		echo '<div class="cat">
			1.Category
			2.Last topic';	
			
		while($row = mysql_fetch_assoc($result))
		{
			echo '<div class="leftpart">';
			echo '3.<a href="category.php?id=' . $row['cat_id'] . '">';
			echo '4.' . $row['cat_name'] . '</a></h3>';
			echo '5.' . $row['cat_description'];
			echo '</td>';
			echo '<td class="rightpart">';
				
				$topicsql = "SELECT
								topic_id,
								topic_subject,
								topic_date,
								topic_cat
							FROM
								topics
							WHERE
								topic_cat = " . $row['cat_id'] . "
							ORDER BY
								topic_date
							DESC
							LIMIT
								1";
								
				$topicsresult = mysql_query($topicsql);
				
				if(!$topicsresult)
				{
					echo 'Last topic could not be displayed.';
				}
				else
				{
					if(mysql_num_rows($topicsresult) == 0)
					{
						echo 'no topics';
					}
					else
					{
						while($topicrow = mysql_fetch_assoc($topicsresult))
						echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
					}
				}
			echo '</td>';
			echo '</tr>';
		}
	}
}

include 'includes/footer.php';
?>

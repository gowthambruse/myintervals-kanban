<?PHP
$url = "https://api.myintervals.com/person?active=t&groupid=4&limit=100";
function getData($url) {
	$username = "<YOUR IP ADDRESS>";
	$password = "X";
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt ( $ch, CURLOPT_USERPWD, "$username:$password" );
	$result = curl_exec ( $ch );
	curl_close ( $ch );
	$result = json_decode ( $result );
	return $result;
}

?>
<style>
.person-head {
	padding-top: 50px;
	padding-bottom: 10px;
	font-family: inherit;
}

.task-list {
	padding: 20px;
	height: 100%;
	overflow: scroll;
}

.Closed {
	display: none;
}
</style>
<link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.css">
<link rel="stylesheet"
	href="http://netdna.webdesignerdepot.com/uploads7/how-to-create-horizontal-scrolling-using-display-table-cell/table-layout-horizontal/css/style.css" />

<div class="well" style="margin-bottom: 0px">Welcome</div>
<section>
	<div class="horizontal" style="height: 90%" tabindex="0">
		<div class="table" id="table" style="height: 100%">
		<?php $result=getData($url);?>
		<?php foreach($result->person as $person){?>
			<article>
				<h3 class="person-head" style=""><?php echo $person->firstname;?></h3>

				<div class="task-list">
				<?php
			$personTask = getData ( "https://api.myintervals.com/task?limit=1000&sortfield=sev.priority&hastaskrelation=" . $person->id );
			foreach ( $personTask->task as $task ) {
				?>
					<div
						class="panel panel-primary <?php echo str_replace(' ', '_', $task->status);?>">
						<div class="panel-heading" style="background-color: <?php echo $task->color;?>">
							<span class="panel-title"><b><?php echo $task->localid;?></b> <span class="pull-right"><?php if($task->datedue!=null){?><i>Due </i><span
									class="label label-primary"><?php echo $task->datedue;?></span></span><?php }?></span>
						</div>
						<div class="panel-body" style="text-align: left;">
							<b style="font-size: 13px;"><?php echo $task->title;?></b>
							<p style="font-size: 10px;"><?php echo $task->summary;?></p>
							<hr>
							<p style="font-size: 11px;">Est: <?php echo $task->estimate;?> | Act: <?php echo $task->actual;?>
							
							</p>
							<small><span class="label label-success"><?php echo $task->status;?></span></small>
							<small><span class="label label-primary"><?php echo $task->project;?></span></small>
						</div>
					</div>
<?php }?>
				</div>

			</article>
			<?php }?>
		</div>
	</div>


</section>
<?php
// print_r ( $personTask);
// print_r(getData("https://api.myintervals.com/task?hastaskrelation=280895"));

?>
<script type="text/javascript"
	src="http://netdna.webdesignerdepot.com/uploads7/how-to-create-horizontal-scrolling-using-display-table-cell/table-layout-horizontal/js/html5shiv.js"></script>

<script type="text/javascript"
	src="http://netdna.webdesignerdepot.com/uploads7/how-to-create-horizontal-scrolling-using-display-table-cell/table-layout-horizontal/js/jquery.js"></script>
<script type="text/javascript"
	src="http://netdna.webdesignerdepot.com/uploads7/how-to-create-horizontal-scrolling-using-display-table-cell/table-layout-horizontal/js/enscroll-0.4.2.min.js"></script>

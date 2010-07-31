<?php
include 'autoload.php';

// check if media target folder is writeable
$storageDir = '/media/aggregateshares/';
if ( !is_writeable( $storageDir ) )
{
	echo "$storageDir can not be written to. Wrong user maybe ?\n";
	die();
}

$sudo = "sudo -u media";
while( $command = MKVMergeCommandQueue::getNextCommand() )
{
	$result = '';
	$return = '';

	// @todo Extract target, sources etc using the same code than mkvmerge.php
	echo "[" . date('H:i:s') . "] Starting conversion of {$command->conversionType} '{$command->title}'\n";
	exec( "$sudo {$command->command}", $result, $return );
	echo "$sudo {$command->command}\n";
	echo "[" . date('H:i:s') . "] Conversion finished\n";


	$q = $db->createUpdateQuery();
	$q->update( 'commands' )
	  ->set( 'status', $q->bindValue( 1 ) )
	  ->set( 'message', $q->bindValue( $return ) )
	  ->where( $q->expr->eq( 'time', $q->bindValue( $command->time ) ) );
	$sth = $q->prepare();
	$sth->execute();

	unset( $result, $return );
}
?>
<?php // $Id: delete.html,v 1.0 2009/08/01 00:00:00 jfruitet Exp $
/**
 * This page defines the form to delete a referentiel_referentiel
 * It is used from /course/delete.php.  The whole instance is available as $form.
 *
 * @author jfruitet
 * @version $Id: delete.html,v 1.0 2009/08/01 00:00:00 jfruitet Exp $
 * @package referentiel
 **/
 
$email_user=referentiel_get_user_mail($USER->id); 
// DEBUG
// echo "<br />EMAIL_USER : $email_user<br />\n";
 
/// First we check that form variables have been initialised
// instance
if (isset($referentiel) &&  ($referentiel) ){

	$ok_creer_importer_referentiel=referentiel_get_item_configuration('creref', $referentiel->id);

	// referentiel referentiel
	if (isset($referentiel->ref_referentiel) && ($referentiel->ref_referentiel>0)){
		$referentiel_referentiel = $DB->get_record("referentiel_referentiel", array("id" => "$referentiel->ref_referentiel"));
	}
	if (!isset($form->instance)) {
    	$form->instance = $referentiel->ref_referentiel;
	}
	else {
    	$form->instance = '';
	}
}
else if (!isset($form->instance)) {
    	$form->instance = '';
}

if (isset($ok_creer_importer_referentiel) && ($ok_creer_importer_referentiel!=0)){
	notice(get_string('suppression_non_autorisee','referentiel'), "view.php?id=$course->id&d=$referentiel->id");
}
else{
	if (isset($referentiel_referentiel) &&  ($referentiel_referentiel) ){
		// MISE A JOUR
		if (!isset($form->referentiel_id)) {
    		$form->referentiel_id = $referentiel_referentiel->id;
		}
		if (!isset($form->instance) || ($form->instance=="")) {
    		$form->instance = $referentiel_referentiel->id;
		}
		
		if (!isset($form->referentiel_id)) {
			$form->instance = $referentiel_referentiel->id;		
		}
		if (!isset($form->name)) {
    		$form->name = $referentiel_referentiel->name;
		}
		if (!isset($form->code_referentiel)) {
    		$form->code_referentiel = $referentiel_referentiel->code_referentiel;
		}
		if (isset($referentiel_referentiel->pass_referentiel)) {
    		$form->pass_referentiel = $referentiel_referentiel->pass_referentiel;
			$form->old_pass_referentiel = $referentiel_referentiel->pass_referentiel;
			$form->suppression_pass_referentiel = false;
		}
		else{
			$form->pass_referentiel = '';
			$form->old_pass_referentiel = '';
			$form->suppression_pass_referentiel = false;
		}
		
		if (isset($referentiel_referentiel->cle_referentiel)) {
    		$form->cle_referentiel = $referentiel_referentiel->cle_referentiel;
		}
		else{
			$form->cle_referentiel='';
		}
		
		if (isset($referentiel_referentiel->mail_auteur_referentiel)
			 && ($referentiel_referentiel->mail_auteur_referentiel!='')) {
	    	$form->mail_auteur_referentiel = $referentiel_referentiel->mail_auteur_referentiel;
		}
		else{
			$form->mail_auteur_referentiel ='';
		}
		
		if (!isset($form->description_referentiel)) {
    		$form->description_referentiel = $referentiel_referentiel->description_referentiel;
		}
		if (!isset($form->url_referentiel)) {
    		$form->url_referentiel = $referentiel_referentiel->url_referentiel;
		}
		if (!isset($form->seuil_certificat)) {
    		$form->seuil_certificat = $referentiel_referentiel->seuil_certificat;
		}
		if (!isset($form->nb_domaines)) {
    		$form->nb_domaines = $referentiel_referentiel->nb_domaines;
		}
		if (!isset($form->liste_codes_competence)) {
    		$form->liste_codes_competence = $referentiel_referentiel->liste_codes_competence;
		}
	
		if (!isset($form->defaultsort)) {
    		$form->defaultsort = '';
		}
		if (!isset($form->defaultsortdir)) {
    		$form->defaultsortdir = '';
		}
		if (!isset($form->courseid)) {
    		$form->courseid = $course->id;
		}
		
		if (!isset($form->local)) {
    		$form->local = $referentiel_referentiel->local;
		}
		
		if (!isset($form->liste_empreintes_competence)) {
    		$form->liste_empreintes_competence = $referentiel_referentiel->liste_empreintes_competence;
		}
	
		if (!isset($form->logo_referentiel)) {
    		$form->logo_referentiel = $referentiel_referentiel->logo_referentiel;
		}
	
		if (!isset($form->sesskey)) {
    		$form->sesskey = sesskey();
		}
		if (!isset($form->mode)) {
    		$form->mode = "update";
		}
	
// DEBUG
// echo "<br />DEBUG :: delete.html :: Ligne 127\n";
// print_r($form);
// exit;

		$records_instance_id=referentiel_referentiel_list_of_instance($form->referentiel_id);
		$nbinstances=0;
		if ($records_instance_id){
			echo '<h4 align="center">'.get_string("selection_instance_referentiel", "referentiel").'</h4>'."\n";
		?>
	<center>
	<form name="form" method="post" action="<?php echo 'delete.php?d='.$referentiel->id.'&amp;pass='.$pass; ?>">
<table cellpadding="5" bgcolor="#eeeeee">
		<?php
			foreach ($records_instance_id  as $record_id){

				$record_instance = referentiel_get_referentiel($record_id->id);
				if ($record_instance){
                    $nbinstances++;
					$record_course = $DB->get_record("course", array("id" => "$record_instance->course"));
		?>
<tr valign="top">
    
<?php
  					if ($record_course->id==$course->id){
						echo '
	<td align="left"><input type="checkbox" name="t_ref_instance[]" value="'.$record_instance->id.'" checked="checked"  /></td>	
	<td align="left"><b>'.get_string('cours_courant','referentiel').' : </b></td>
	<td align="left">'.$record_course->fullname.' ('.$record_course->shortname.')</td>'."\n";
					}
					else{
						echo '
	<td align="left"><input type="checkbox" name="t_ref_instance[]" value="'.$record_instance->id.'"  /></td>	
	<td align="left"><b>'.get_string('cours_externe','referentiel').' : </b></td>
	<td align="left"><a href="'.$CFG->wwwroot.'/course/view.php?id='.$record_course->id.'">'.$record_course->fullname.'</a> ('.$record_course->shortname.')</td>'."\n";
					}				
?>
    <td align="left"><b><?php  print_string('name_instance','referentiel') ?>:</b></td>
    <td align="left">
    	   <?php  p($record_instance->name); ?>
    </td>
    <td align="left"><b><?php  print_string('description_instance','referentiel') ?>:</b></td>
    <td align="left">
			<?php  p(strip_tags($record_instance->description_instance)); ?>
    </td>
</tr>

<?php
				}
			}
?>
</table>
<br />
<!-- These hidden variables are always the same -->
<input type="hidden" name="action" value="supprimerinstances" />
<input type="hidden" name="referentiel_id"      value="<?php  p($form->referentiel_id) ?>" />
<input type="hidden" name="sesskey"     value="<?php  p($form->sesskey) ?>" />
<input type="hidden" name="courseid"        value="<?php  p($form->courseid) ?>" />
<input type="hidden" name="instance"      value="<?php  p($form->instance) ?>" />
<input type="hidden" name="mode"          value="<?php  p($form->mode) ?>" />

<input type="submit" name="delete" value="<?php  print_string("delete") ?>" />
<input type="reset"  value="<?php  print_string("cancel") ?>" />
<input type="submit" name="cancel" value="<?php  print_string("quit", "referentiel") ?>" />
</form>
</center>
<?php
		}
		else { // proposer la suppression

?>

<form name="form" method="post" action="<?php p("delete.php?d=".$referentiel->id."&amp;pass=".$pass) ?>">

<table cellpadding="5" align="center">
<tr valign="top">
    <td align="right"><b><?php  print_string('name','referentiel') ?>:</b></td>
    <td align="left">
    	    <?php  echo stripslashes($form->name) ?>
    </td>
</tr>
<tr valign="top">
    <td align="right"><b><?php  print_string('code','referentiel') ?>:</b></td>
    <td align="left">
        	<?php  echo ($form->code_referentiel) ?>
    </td>
</tr>
<?php
		  if (isset($form->mail_auteur_referentiel) && ($form->mail_auteur_referentiel!='')){
			echo '
<tr valign="top">
    <td align="right"><b>'.get_string('auteur','referentiel').' : </b></td>
    <td align="left">
        '.$form->mail_auteur_referentiel.'
    </td>
</tr>
';
		  }

		  if (($form->pass_referentiel=='') && ($form->mail_auteur_referentiel=='')){ // nouveau referentiel
			echo '<tr valign="top">
    <td align="right"><b>'.get_string('pass_referentiel','referentiel').' :</b></td>
    <td align="left">'.get_string('aide_pass_referentiel','referentiel').'
    </td>
</tr>
';
		  }
		  else if (($form->mail_auteur_referentiel!='')
		&& (trim($email_user)==trim($form->mail_auteur_referentiel))) { // mise a jour
			echo '
<tr valign="top">
    <td align="right"><b>';
			if ($form->pass_referentiel!=''){
				echo get_string('ressaisir_pass_referentiel','referentiel');
			}
			else {
				echo get_string('pass_referentiel','referentiel');
			}
			echo ' :</b></td>
    <td align="left">
';
			if (($form->pass_referentiel!='')){
				print_string('existe_pass_referentiel','referentiel');
			}
			else{
				print_string('aide_pass_referentiel','referentiel');
			}
			echo '
    </td>
</tr>
';
		  }
?>
<tr valign="top">
    <td align="right"><b><?php  print_string('description','referentiel') ?>:</b></td>
    <td align="left">
			<?php  echo ($form->description_referentiel) ?>
    </td>
</tr>
<tr valign="top">
    <td align="right"><b><?php  print_string('url','referentiel') ?>:</b></td>
    <td align="left">
    	    <?php  p($form->url_referentiel) ?>
    </td>
</tr>
<tr valign="top">
    <td align="right"><b><?php  print_string('logo','referentiel') ?>:</b></td>
    <td align="left">
       	<?php  p($form->logo_referentiel) ?>
    </td>
</tr>

<tr valign="top">
    <td align="right"><b><?php  print_string('seuil_certificat','referentiel') ?>:</b></td>
    <td align="left">
     	  <?php  p($form->seuil_certificat) ?>
    </td>
</tr>
<tr valign="top">
    <td align="right"><b><?php  print_string('referentiel_global','referentiel') ?>:</b></td>
    <td align="left">
<?php	
		if (isset($form->local)){
			if ($form->local!=0){
			echo  get_string("no")."\n";
		}
		else{
			echo  get_string("no")."\n";
		}
	}
	else {
		echo  get_string("no")."\n";
	}
?>
    </td>
</tr>
<tr valign="top">
    <td align="right"><b><?php  print_string('nombre_domaines_supplementaires','referentiel') ?>:</b></td>
    <td align="left">
        <?php  p($form->nb_domaines) ?>
    </td>
</tr>
<tr valign="top">
<td colspan="2" align="center">
<input type="hidden" name="action" value="modifierreferentiel" />
<input type="hidden" name="referentiel_id"      value="<?php  p($form->referentiel_id) ?>" />
<!-- These hidden variables are always the same -->
<input type="hidden" name="mail_auteur_referentiel" value="<?php  p($form->mail_auteur_referentiel); ?>" />
<input type="hidden" name="old_pass_referentiel" value="<?php  p($form->old_pass_referentiel); ?>" />
<input type="hidden" name="cle_referentiel" value="<?php  p($form->cle_referentiel); ?>" />
<input type="hidden" name="liste_codes_competence" value="<?php  p($form->liste_codes_competence); ?>" />
<input type="hidden" name="liste_empreintes_competence" value="<?php  p($form->liste_empreintes_competence); ?>" />
<input type="hidden" name="sesskey"     value="<?php  p($form->sesskey) ?>" />
<input type="hidden" name="courseid"        value="<?php  p($form->courseid) ?>" />
<input type="hidden" name="instance"      value="<?php  p($form->instance) ?>" />
<input type="hidden" name="mode"          value="<?php  p($form->mode) ?>" />


<input type="submit" name="delete" value="<?php  print_string("delete") ?>" />
<input type="submit" name="cancel" value="<?php  print_string("quit", "referentiel") ?>" />
</td>
</tr>
</table>

</form>
<?php
		}
	}
}
?>


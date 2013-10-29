<?php
class HTML extends DBconnection
{
    /* vars */
    var $type;
    var $attributes;
    var $self_closers;

    /* constructor */
   
    /* get */
    function get($attribute)
    {
	    return $this->attributes[$attribute];
    }

    /* set -- array or key,value */
    function set($attribute,$value = '')
    {
	    if(!is_array($attribute))
	    {
		    $this->attributes[$attribute] = $value;
	    }
	    else
	    {
		    $this->attributes = array_merge($this->attributes,$attribute);
	    }
    }

    /* remove an attribute */
    function remove($att)
    {
	    if(isset($this->attributes[$att]))
	    {
		    unset($this->attributes[$att]);
	    }
    }

    /* clear */
    function clear()
    {
	    $this->attributes = array();
    }

    /* inject */
    function inject($object)
    {
	    if(@get_class($object) == __class__)
	    {
		    $this->attributes['text'].= $object->build();
	    }
    }

    /* build */
    function build()
    {
	    //start
	    $build = '<'.$this->type;

	    //add attributes
	    if(count($this->attributes))
	    {
		    foreach($this->attributes as $key=>$value)
		    {
			    if($key != 'text') { $build.= ' '.$key.'="'.$value.'"'; }
		    }
	    }

	    //closing
	    if(!in_array($this->type,$this->self_closers))
	    {
		    $build.= '>'.$this->attributes['text'].'</'.$this->type.'>';
	    }
	    else
	    {
		    $build.= ' />';
	    }

	    //return it
	    return $build;
    }

    /* spit it out */
    function output()
    {
	    echo $this->build();
    }
    
    function grid($data) {
	$dataValue = "";
	$dataValue .='<table class="table table-hover table-striped table-bordered">';
	//exit;
	$dataValue .='<thead><tr>';
	foreach($data['header'] as $headers)
	{
	   $dataValue .='<th>'.$headers.'</th>';  
	}
	$dataValue .='</tr></thead>';
	$dataValue .='<tbody>';
	foreach($data['data'] as $key=>$value){
	    $dataValue .='<tr>';
	    $dataValue .='<td>'.$key.'</td>';
	    foreach($value as $dataValues){
		if(isset($dataValues) && is_array($dataValues)){
		    foreach($dataValues as $valuesTotal){
			$dataValue .='<td>'.$valuesTotal.'</td>';
		    }
		} else {
		    $dataValue .='<td>0</td>';
		}
		
	    }
	    $dataValue .='</tr>';
	}
	$dataValue .='</tbody>';
	$dataValue .='</table>';
	return $dataValue;
    }
    
    function test() {
	echo "test hello";
	exit;
    }
}
?>

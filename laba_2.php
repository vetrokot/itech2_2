
<?php
  require 'db_connect.php';
?>

<script>

var ajax;
InitAjax();
function InitAjax() 
{
	try 
	{ /* пробуем создать компонент XMLHTTP для IE старых версий */
	ajax = new ActiveXObject("Microsoft.XMLHTTP");
	} 
		catch (e) 
		{
		try 
			{//XMLHTTP для IE версий >6
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch (e) 
			{
			    try 
				{// XMLHTTP для Mozilla и остальных
				ajax = new XMLHttpRequest();
				} 
				catch(e) 
				{ ajax = 0; }
			}
		}
}

function sendAjaxGetRequest(request_string,response_handler)
{
	if (!ajax) 
	{
		alert("Ajax не инициализирован");
		return;
	}
	ajax.onreadystatechange = response_handler;
	ajax.open( "GET", request_string, true );
	ajax.send(null);
}

function task1()
{
    var value = document.getElementById("date1").value;
    var params = 'date1=' + encodeURIComponent(value);
    sendAjaxGetRequest("form1.php?"+params, onTask1Response);
}

function task2()
{
    var value = document.getElementById("date2").value;
    var params = 'date2=' + encodeURIComponent(value);
    sendAjaxGetRequest("form2.php?"+params, onTask2Response);
}

function task3()
{
	var value = document.getElementById("vendorname").value;
    var params = 'vendorname=' + encodeURIComponent(value);
	sendAjaxGetRequest("form3.php?"+params, onTask3Response);
}

function onTask1Response()
{
    if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{
			var d1 = document.getElementById('date1'); 
			d1.insertAdjacentHTML('afterend', ajax.responseText);
		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

function onTask2Response()
{

	if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{
			var d1 = document.getElementById('date2'); 
			alert(ajax.responseText);
			var obj = JSON.parse(ajax.responseText);
			
			d1.insertAdjacentHTML('afterend', "<table id='date2_table' style='border:solid 1px black;'><tr><th>name</th><th>price</th></tr></table>");
			var table = document.getElementById('date2_table'); 
			for(var i in obj)
			{
				var tr = document.createElement("tr");
				tr.innerHTML = '<td>'+obj[i]["Name"]+'</td> <td>'+obj[i]["Price"]+'</td>';
				table.appendChild(tr);
			}

		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

function onTask3Response()
{
	if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{ 
		alert(ajax.responseText);
			var d1 = document.getElementById('vendorname');
			d1.insertAdjacentHTML('afterend', "<table id='vendor_table' style='border: solid 1px black;'><tr><th>name</th><th>race</th></tr></table>");
			var table = document.getElementById('vendor_table'); 
			var xml = ajax.responseXML;
			for (var i = 0; i < xml.getElementsByTagName("Name").length; i++) {
			var result = document.createElement("tr");
			result.innerHTML += "<td>" + xml.getElementsByTagName("Name")[i].childNodes[0].nodeValue + "</td>";
			result.innerHTML  += "<td>" + xml.getElementsByTagName("Race")[i].childNodes[0].nodeValue + "</td>";
			table.appendChild(result);
			}
		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

</script> 

<p><b>получить доход с проката по состоянию на выбранную дату</b></p>
<form method="get">
<p><input type="date" name="date1" id="date1"></p>
<p><input type="button" value="выбрать" onclick=task1();></p>
</form>

<p><b>свободные автомобили на выбранную дату</b></p>
<form method="get">
<p><input type="date" name="date2" id="date2"></p>
<p><input type="button" value="выбрать" onclick=task2();></p>
</form>

<p><b>автомобили выбранного производителя</b></p>
<form method="get">
<select name="vendorname" id="vendorname">
<?php
	$res=$dbh->query("SELECT DISTINCT Name FROM vendors");
foreach($res as $row) {
	echo "<option value=$row[0]>$row[0]</option>";
}
?>
</select>
<p><input type="button" value="выбрать" onclick=task3();></p>
</form>

<p><b>добавление информации об аренде для выбранного автомобиля на указанные даты</b></p>
<form action="form4.php" method="get">
<p>дата начала аренды</p>
<p><input type="date" name="startdate"></p>
<p>дата конца аренды</p>
<p><input type="date" name="enddate"></p>
<select name="rentcar">
<?php
	$res=$dbh->query("SELECT DISTINCT ID_Cars FROM cars");
foreach($res as $row) {
	echo "<option value=$row[0]>$row[0]</option>";
}
?>
</select> 
<p><input type="submit" value="арендовать"></p>
</form>

<p><b>изменение информации о пробеге машины</b></p>
<form action="form5.php" method="get">
<p>выберите машину, пробег которой вы хотите изменить</p>
<select name="racecar">
<?php
	$res=$dbh->query("SELECT DISTINCT ID_Cars FROM cars");
foreach($res as $row) {
	echo "<option value=$row[0]>$row[0]</option>";
}
?>
</select> 
<p>введите новый пробег</p>
<p><input type="text" name="race"></p>

<p><input type="submit" value="арендовать"></p>
</form>


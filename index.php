<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title> XML Demo </title>
<style>
#resultTable {
	border-collapse: collapse;
}

#resultTable, #resultTable th, #resultTable td {
	border: 1px solid black;
}

form td {
		text-align: right;
}
</style>
<script>
//AJAX script
function callback(form) {
	var table; //the html to insert
	var book; //the list of books returned
	var subElement; // a subelement of a book
	var i; //loop counter
	var http; //the http request
	var params = "title="+form.elements["title"].value+"&author="+form.elements["author"].value;
	http = new XMLHttpRequest();
	http.open("GET", "callback.php?"+params, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");
	http.onreadystatechange = function() {
		if(http.readyState==4 && http.status==200) {
			table="\n<table id='resultTable'>\n<tr><th>Title</th><th>Author</th></tr>\n";
			book=http.responseXML.documentElement.getElementsByTagName("row");
			for(i=0; i<book.length; i++) {
					table+="<tr>";
					subElement=book[i].getElementsByTagName("title");
					try {
							table+="<td>"+subElement[0].firstChild.nodeValue+"</td>";
					} catch (e) { //in case this ^ doesn't exist
							table+="<td></td>";
					}
					subElement=book[i].getElementsByTagName("author");
					try {
							table+="<td>"+subElement[0].firstChild.nodeValue+"</td>";
					} catch (e) {
							table+="<td></td>";
					}
					table+="</tr>\n";
			}
			table+="</table>\n";
			document.getElementById("result").innerHTML=table;
		}
	}
	http.send();

}
</script>
</head>
<body>
<h1>Your Local Library's Online Electronic Card Catalog</h1>
<i>Early Alpha (v0.0.0.1)</i><br><br>

<form onsubmit="callback(this);return false;">
<table>
<tr><td>Title:</td><td><input type="text" name="title"></td></tr>
<tr><td>Author:</td><td><input type="text" name="author"></td></tr>
</table>
<input type="submit" value="Search!">
</form>

<br>
<div id="result">
</div>

</body>
</html>

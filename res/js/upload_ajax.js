function init() {
	var dropbox = document.getElementById('dropbox');        
	dropbox.addEventListener('dragenter', noopHandler, false);
	dropbox.addEventListener('dragexit', noopHandler, false);
	dropbox.addEventListener('dragover', noopHandler, false);
	dropbox.addEventListener('drop', drop, false);
}

function noopHandler(evt) 
{
evt.stopPropagation();
evt.preventDefault();   
}   

function drop(evt) 
{
	evt.stopPropagation();
	evt.preventDefault();
	var files = evt.dataTransfer.files;
	var count = files.length; 
	for (i=0; i<count;i++) 
	{   
		var formData = new FormData();
		formData.append("file", files[i]);

		var newRequest = new XMLHttpRequest();
		newRequest.open("POST", "upload_ajax.php", true);
		//newRequest.addEventListener("load", transferComplete, false);
		newRequest.send(formData);
		location.reload();
		//window.location.href = "index.php";
	}
}         



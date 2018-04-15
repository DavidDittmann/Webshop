function checkEingaben()
{
    var uname = document.getElementById("uname").value;
    var vname = document.getElementById("vname").value;
    var nname = document.getElementById("nname").value;
    var Password = document.getElementById("pwd").value;
    var Email = document.getElementById("mail").value;

    var PassCheck = /^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*._-]{8,}$/;
    var MatrCheck = /^[0-9]{10}$/;
    var EmailCheck = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,5}$/;
    var Error=0;	

    if(uname.length<3 || uname.length>20)
    {
        document.getElementById("uname").style.border = "2px solid red";
        window.alert("Username muss mind. 3, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("uname").style.border = "1px solid black";

    if(vname.length<1 || vname.length>20)
    {
        document.getElementById("vname").style.border = "2px solid red";
        window.alert("Username muss mind. 1, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("vname").style.border = "1px solid black";

    if(nname.length<1 || nname.length>20)
    {
        document.getElementById("nname").style.border = "2px solid red";
        window.alert("Username muss mind. 1, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("nname").style.border = "1px solid black";


    if(Password.match(PassCheck))   
    {    
        document.getElementById("pwd").style.border = "1px solid black";
    }  
    else  
    {   
        alert("Passwort inkorrekt! Mind. 8 Zeichen davon 1 Grossbuchstabe, 1 Sonderzeichen und 1 Zahl!");
        document.getElementById("pwd").style.border = "2px solid red";
        Error=1;		
    }

    if(Email.match(EmailCheck))   
    {    
        document.getElementById("mail").style.border = "1px solid black";
    }  
    else  
    {   
        alert("Email ist falsch!");
        document.getElementById("mail").style.border = "2px solid red";
        Error=1;		
    }

    if(Error==1)
        return false;
    else
        return true;
}




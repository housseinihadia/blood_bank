// JavaScript Document
var myIndex = 0 ;

replay() ;

function replay() {
    
	"use strict";
    
    var i ;
    
    var x = document.getElementsByClassName("slide");
    
    for (i = 0; i < x.length; i++) 
        
	{
        
        x[i].style.display = "none";
        
    }
    myIndex++;
    
    if (myIndex > x.length) {myIndex = 1;} 
    
    x[myIndex-1].style.display = "block"; 
    
    setTimeout(replay,4000); 
}
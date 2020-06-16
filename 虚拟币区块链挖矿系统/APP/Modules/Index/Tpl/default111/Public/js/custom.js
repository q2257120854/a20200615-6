
function ShowMenu(srcElm) { 
  	var MenuTable = $('a[onclick="ShowMenu(this)"]');
	var menuList = $('div[class="sec_menu"]');
	
	for(i=0;i<menuList.length;i++)
	{
		MenuTable[i].className="";
	
		if(MenuTable[i]==srcElm)
		{
			MenuTable[i].className = "selected";
			menuList[i].style.display = "";	
		}
		else
		{
			MenuTable[i].className = "";
			menuList[i].style.display = "none";
		}
	}
}

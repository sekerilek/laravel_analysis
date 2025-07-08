<input type="textbox" class="txt" id="txt"/>
<button  onclick="enable()" >disabled</buton>
<button onclick="disable()" >not disabled</button>
<script language="JavaScript" type="text/javascript" src="/js/jquery-1.2.6.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/jquery-ui-personalized-1.5.2.packed.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/sprinkle.js"></script>
<script>
function enable(){
    document.getElementById("txt").disabled=true;
}
function disable(){
    document.getElementById("txt").disabled=false;
}
</script>

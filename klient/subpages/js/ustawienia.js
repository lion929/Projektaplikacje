function enble()
{
    var check = document.getElementById("enable");
    var inputs = document.getElementsByClassName("form-control");
    var submit = document.getElementById("submit");

    if(check.checked == true)
    {
        for(var i=0; i<inputs.length; i++)
        {
            inputs[i].disabled = false;
        }

        submit.disabled = false;
    }
    
    else
    {
        for(var i=0; i<inputs.length; i++)
        {
            inputs[i].disabled = true;
        }

        submit.disabled = true;
    }
}

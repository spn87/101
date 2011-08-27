
function  FadeGalleryPlugin_animateFade(lastTick, eid,endopacity,fadeStep,TimeToFade)
{
 
  var curTick = new Date().getTime();
  var elapsedTicks = curTick - lastTick;
 
  var element = document.getElementById(eid);
 
  if(element.FadeTimeLeft <= elapsedTicks)
  {
    element.style.opacity = element.FadeState == 1 ? (1*endopacity) : '0';
    element.style.filter = 'alpha(opacity = '
        + (element.FadeState == 1 ? (100*endopacity) : '0') + ')';
    element.FadeState = element.FadeState == 1 ? 2 : -2;
    return;
  }
 
  element.FadeTimeLeft -= elapsedTicks;
  var newOpVal = element.FadeTimeLeft/TimeToFade;
  if(element.FadeState == 1)
    newOpVal = 1 - newOpVal;

  
  element.style.opacity = newOpVal*endopacity;
  element.style.filter = 'alpha(opacity = ' + (newOpVal*100*endopacity) + ')';
 
  setTimeout("FadeGalleryPlugin_animateFade(" + curTick + ",'" + eid + "',"+endopacity+","+fadeStep+","+TimeToFade+")", fadeStep);
}
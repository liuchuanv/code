
$(function(){
    $("#start").bind('click',function(){
        var prize = [2,3,5,6,8,10,12];
        paomadeng.txt = "恭喜你";
        paomadeng.prize = prize[2];
        paomadeng.reset();
    });
});

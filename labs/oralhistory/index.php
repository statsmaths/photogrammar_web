<?php $page = labs; ?>
<?php include '../../header.php'; ?>

<script src="popcorn-complete.min.js"></script>
<style>
div#textdiv {
	font-size:2em;
}

</style>
<script>
  // ensure the web page (DOM) has loaded
  document.addEventListener("DOMContentLoaded", function () {

     // Create a popcorn instance by calling Popcorn("#id-of-my-video")
     var pop = Popcorn("#ohgparks");


     pop.footnote({
       start: 0,
       end: 1,
       text: "<br><br><img class='img-responsive' src='http://maps.library.yale.edu/images/public/photogrammar/large/0520/0524/05811v.jpg' />",
       target: "picdiv"
     }).footnote({start: 1,
       end: 10,
       text: "<img  class='img-responsive' src='http://photogrammar.research.yale.edu/photos/service/pnp/fsa/8b14000/8b14800/8b14896v.jpg'>",
       target: "picdiv"
}).footnote({start: 1,
       end: 10,
       text: "So he said, &quot;Go out and see these things, the people, eat here, go to a theatre, go to the department store and buy yourself a coat. You need a coat.&quot;",
       target: "textdiv"
})



.footnote({start: 10,
       end: 20,
       text: "<img  class='img-responsive' src='http://photogrammar.research.yale.edu/photos/service/pnp/fsa/8d10000/8d10000/8d10074v.jpg'>",
       target: "picdiv"
})
.footnote({start: 10,
       end: 20,
       text: "And I came back roaring mad and I wanted my camera and he said, &quot;For what?&quot; and I said I wanted to expose some of this corruption down here, this discrimination. ",
       target: "textdiv"
}).footnote({start: 20,
       end: 30,
       text: "And he says, &quot;How you gonna do it?&quot; &quot;Well, with my camera.&quot; So he says, &quot;Well, you sit down and write me a little paper on how you intend to do this,&quot; and I said, &quot;Fine.&quot;",
       target: "textdiv"


}).footnote({
	   start: 30,
       end: 39,
       text: "I sat down, wrote several papers, brought them in. He kept after me until he got me down to one simple little project.",
       target: "textdiv"
}).footnote({start: 39,
       end: 57,
       text: "That was my first lesson in how to approach a subject, that you didn't have to go blaring in with all horns blasting away, but I did a picture there that he often laughed at because of, I suppose, of what I thought was the shock appeal of it.",
       target: "textdiv"
}).footnote({start: 58,
       end: 66,
       text: "He finally got me to talk to a charwoman out in the hall, a Negro lady, and ask her some questions.",
       target: "textdiv"

}).footnote({start: 67,
       end: 71,
       text: "As simple as that and I came to find out a very significant thing.",
       target: "textdiv"
}).footnote({start: 72,
       end: 86,
       text: "She had moved into the building at the same time she said as the woman who was now a notary public. They came there with the same education, the same mental facilities and equipment and she was now scrubbing this woman's room every evening. ",
       target: "textdiv"

}).footnote({start: 87,
       end: 110,
       text: "So out of her I got a charming story but in the heat of all this I took her into this woman's office and there was the American flag and I stood her up with her mop hanging down with the American flag hanging down Grant Wood style and did this marvelous portrait, which Stryker thought it was just about the end.",
       target: "textdiv"
}).footnote({start: 110,
       end: 110,
       text: "He said, &quot;My God, this can't be published, but it's a {start.&quot; So it was published. I sneaked it out and published it in an old paper that used to be in Brooklyn. It was published in Brooklyn, you probably remember, what was it called? I forget, a Marshall Field paper, do you remember that one?",
       target: "textdiv"
});

     // play the video right away
     pop.play();

  }, false);

</script>

  <div class="container marketing" style="z-index:-1; padding-top:70px">
	   <div class="row" >
	        <div style="border:1px dotted green;" class="col-lg-4 col-md-4 col-sm-4">
	        	 <audio id="ohgparks" style="width:100%;" controls>
			      <source src="parks.mp3">

			    </audio>
	        	<div id="picdiv"></div>
			   
	        </div>
	        
	        <div class="col-lg-8 col-md-8">
				<div id="textdiv"></div>
			</div> 	    
	   </div>    
			     
   </div>
			    

			

      <hr>


    </div> <!-- /container -->


<?php include '../../footer.php'; ?>

<?php $page = labs; ?>
<?php include '../header.php'; ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container marketing" style="z-index:-1; padding-top:75px">

      <!-- Three columns of text below the carousel -->
      <div class="row">
         <div class="col-xs-12 col-sm-12"><h1>Photogrammar Labs <i class="fa fa-flask"></i> </h1><p>This section presents data experiments and tools for exploring and interpreting the FSA-OWI collection.
</p><hr></div>

        <div class="col-xs-6 col-sm-4">
          <a href="/labs/treemap"><img class="img" style="height:150px;width:244px;" src="../images/labs-treemap-icon.png" alt="treemap" ></a>
          <h2>Treemap</h2>
         <p>Visualization of the classification system designed by Paul Vanderbilt in 1942. It is a three-tier classification starting with 12 main subject headings (ex. THE LAND), then 1300 sub-headings (ex. Mountains, Deserts, Foothills, Plains) and then  sub-sub headings. 88,000 photographs were assigned classifications. </p>  
	<p><a class="btn btn-default" href="/labs/treemap" role="button"><i class="fa fa-trello" style="margin-right:5px;"></i>Treemap</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-xs-6 col-sm-4">
          <a href="crossfilter/california/"><img class="img" src="../images/labs-crossfilter-icon.png" alt="Crossfilter" style="height:150px;width:286px;" ></a>
          <h2>Metadata Dashboard</h2>
         <p>Interactive dashboard showing the relationship between date, county, photographer, and subject in photographs from individual states.  The dashboard is still in development, but California is now available.
</p>  
	<p><a href="crossfilter/california/" class="btn btn-default" href="#" role="button"><i class="fa fa-tachometer" style="margin-right:5px;"></i>   Metadata Dashboard</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-xs-6 col-sm-4">
          <img class="img" src="../images/colorspace.png" alt="colorspace" height=150px>
          <h2>ColorSpace</h2>
         <p>Explore the 17,000 color photographs based on hue, saturation and lightness. 
</p>  
	<p><a class="btn btn-default" href="#" role="button">Coming soon!</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      <!-- FOOTER -->
      <footer>
      </footer>

    </div><!-- /.container -->

<?php include '../footer.php'; ?>

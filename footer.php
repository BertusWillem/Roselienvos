 <!--footer-->
    <footer>
      <!-- &copy; <?php echo date("Y");?> -->
      <a>Deze site is gemaakt door: </a>
      <a class="user" href="http://google.nl/">Team Aqua.</a>
    </footer>
    <!-- Start to top button -->
<button onclick="topFunction()" id="myBtn" title="Go to top">&uarr;</button>

<script>
// Wanneer de gebruiker 20 px naar beneden scrolt vanaf de bovenkant van de pagina, wordt de to top knop weergegeven
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// Wanneer de gebruiker op de knop klikt, scrollt de pagina weer weer helmaal naar de bovenkant
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>
<!-- End to top button -->

 <!--Opmaak van de to top button-->
<style>
/*To top*/
#myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  border: none;
  outline: none;
  background-color: #3498DB;
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 10px;
}

#myBtn:hover {
  background-color: #00BCD4;
}
/*To top End*/
</style>
  </body>
</html>

const chessModule = `<div class = "box">
<h1 class = "text-center">Cheeky Chess</h1>
    <table class ="content">
        <thead><div id="position">&nbsp;</div></thead>
        <tr>
            <td><div id = "a8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b8" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d8" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f8"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g8" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h8" class="darkSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f7" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g7" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h7" class="lightSquares">&nbsp;</div></td>
        </tr>
        
        <tr>
            <td><div id = "a6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b6" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d6" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f6"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g6" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h6" class="darkSquares">&nbsp;</div></td>
        </tr>
    
        <tr>
            <td><div id = "a5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f5" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g5" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h5" class="lightSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b4" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d4" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f4"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g4" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h4" class="darkSquares">&nbsp;</div></td>
        </tr>
    
        <tr>
            <td><div id = "a3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f3" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g3" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h3" class="lightSquares">&nbsp;</div></td>
        </tr>

        <tr>
            <td><div id = "a2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "b2" class="darkSquares">&nbsp;</div></td>
            <td><div id = "c2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "d2" class="darkSquares">&nbsp;</div></td>
            <td><div id = "e2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "f2"  class="darkSquares">&nbsp;</div></td>
            <td><div id = "g2" class="lightSquares">&nbsp;</div></td>
            <td><div id = "h2" class="darkSquares">&nbsp;</div></td>
        </tr>
        <tr>
            <td><div id = "a1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "b1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "c1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "d1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "e1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "f1" class="lightSquares">&nbsp;</div></td>
            <td><div id = "g1" class="darkSquares">&nbsp;</div></td>
            <td><div id = "h1" class="lightSquares">&nbsp;</div></td>
        </tr>
    </table>
</div>`;


window.onload = function() {

    $("#chess-game").on("click", () => {
        console.log("clicked")

        document.getElementById("game-area").innerHTML = chessModule;
        // chessGame();
    })


















  }//end of onload - keep all jquery here








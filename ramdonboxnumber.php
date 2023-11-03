<!DOCTYPE html>
<html>
<head>
  <style>
    .box-container {
      display: grid;
      grid-template-columns: repeat(10, 50px);
      grid-gap: 5px;
    }
    .box {
      width: 50px;
      height: 50px;
      border: 1px solid black;
      text-align: center;
      line-height: 50px;
      cursor: pointer;
    }
    .selected {
      background-color: green;
    }
  </style>
</head>
<body>
  <h2>Rando Bingo</h2>

  <div class="box-container" id="boxContainer">

    <?php
    $numbers = range(1, 100);
    shuffle($numbers);
    shuffle($numbers); 
    for ($i = 0; $i < 100; $i++) {

      echo "<div class='box' data-number='{$numbers[$i]}' data-selected='0'>" . $numbers[$i] . "</div>";

    }
    ?>

  </div>

  <br>
  
  <button id="PlayBTN">Play</button>

  <br>

  <div>

    <p>Matched:</p>
    <div id="listContainer"></div>

  </div>

  <script>

    const pickButton = document.getElementById('PlayBTN');
    const boxContainer = document.getElementById('boxContainer');
    const listContainer = document.getElementById('listContainer');

    let matchednum = [];

    
    const shuffleBoxes = () => {

      const boxes = Array.from(boxContainer.querySelectorAll('.box'));
      shuffleArray(boxes);
      boxContainer.innerHTML = '';
      boxes.forEach(box => boxContainer.appendChild(box));

    };

    
    const shuffleArray = (array) => {

      for (let i = array.length - 1; i > 0; i--) {

        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];

      }
    };

    pickButton.addEventListener('click', () => {

      const remainingBoxes = Array.from(boxContainer.querySelectorAll('.box:not(.selected)'));

      if (remainingBoxes.length > 0) {

        const randomIndex = Math.floor(Math.random() * remainingBoxes.length);
        const selectedBox = remainingBoxes[randomIndex];
        const selectedNum = selectedBox.getAttribute('data-number');

        selectedBox.classList.add('selected');
        selectedBox.setAttribute('data-selected', '1');
        matchednum.push(selectedNum);

        const listItem = document.createElement('div');
        listItem.textContent = selectedNum;

        if (listContainer.innerHTML) {
          listContainer.innerHTML += ', ' + selectedNum;
        } 
        else {
          listContainer.innerHTML = selectedNum;
        }

        shuffleBoxes(); 

        if (listContainer.childElementCount === 100) {
          pickButton.textContent = 'Reset Progress';
        }
      } 
      else {
        
        const boxes = Array.from(boxContainer.querySelectorAll('.box'));
        boxes.forEach(box => {
          box.classList.remove('selected');
          box.setAttribute('data-selected', '0');
        });
        listContainer.innerHTML = '';
        shuffleBoxes(); 
        pickButton.textContent = 'Pick a Number';

      }
    });
  </script>
</body>
</html
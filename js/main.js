const result = document.getElementById('result');
const keys = [ ...document.getElementsByClassName('key')];
const expression = document.getElementById('expression');
// console.log(expression.value);
const exclude = ['equals', 'AC', 'DEL'];
const nums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

function clearResults() {
    result.textContent = "0";
    expression.value = "";
}

keys.forEach(key => {
    // console.log(key.classList.contains('sci'));
    key.addEventListener('click', (e) => {
        // if(key.getAttribute)
        const classList = [ ...key.classList ];

        if(result.textContent === "invalid syntax" && classList.includes('pow')) {
            result.textContent = "0";
            expression.value = "";
            return ;
        }

        if(classList.includes('AC')) {
            clearResults();
            return ;
        }

        if(classList.includes('DEL')) {
            if(result.textContent === "0") return ;

            if(result.textContent === "invalid syntax") {
                clearResults();
                return ;
            }

            if(result.textContent[result.textContent - 1] === "^") {
                const str = result.textContent.slice(0, -1);
                result.textContent = str.length === 0 ? '0' : str;
                expression.value = result.textContent.slice(2, -1);
                console.log(expression);
                return
            }
            
            const str = result.textContent.slice(0, -1);
            result.textContent = str.length === 0 ? '0' : str;
            expression.value = str;
        }
        
        if(!exclude.some(i => classList.includes(i))) {
            if(classList.includes('pow') && result.textContent === '0') {
                return ;
            }

            if(result.textContent === "invalid syntax") {
                result.textContent = e.target.value;
                expression.value = e.target.value;
            }

            if(e.target.value === result.textContent[result.textContent.length - 1] || classList.includes('pow') && result.textContent[result.textContent.length - 1] === "^") {
                return ;
            }

            if(result.textContent === '0') {
                result.textContent = "";
            }
            
            if(classList.includes('pow') && result.textContent.length > 0 && nums.includes(result.textContent[result.textContent.length - 1])) {
                const displayText = result.textContent;
                result.textContent = displayText + '^';
                expression.value = expression.value + '**';
                console.log(expression);
                return ;
            }

            if(classList.includes('sci') || classList.includes('sqrt')) {
                const displayText = result.textContent;
                result.textContent = displayText + e.target.textContent + '(';
                expression.value = expression.value + e.target.textContent + '(';

                return ;
            }

            const displayText = result.textContent;
            result.textContent = displayText + e.target.textContent;
            expression.value = expression.value + e.target.textContent;
            // console.log("last", expression);
        }
    })
});
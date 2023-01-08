/*window.addEventListener("load", () => {
    let taxes = {
        710: 0,
        1015: 11.3,
        1577: 17.2,
        2109: 21.9,
        5241: 32.3,
        11384: 39.2,
        25505: 43.8,
    };
    let typeMealAllowance = document.getElementById("tiporefeicao");
    let mealAllowance = document.getElementById("meal_allowance_amount");
    let mealDays = document.getElementById("meal_days");
    console.log("Batas");
    document.getElementById("tiporefeicao").addEventListener("change", () => {
        if (document.getElementById("tiporefeicao") === "no_allowance") {
            mealAllowance.value = 0;
            mealDays.value = 0;
            document.getElementById("valorSub").disabled = true;
            document.getElementById("dias").disabled = true;
        } else {
            console.log("fds");
            document.getElementById("valorSub").disabled = false;
            document.getElementById("dias").disabled = false;
        }
    });

    mealDays.addEventListener("change", () => {
        //if already exists error message delete it
        if (mealDays.parentNode.querySelector("span")) {
            mealDays.parentNode.querySelector("span").remove();
            mealDays.style.border = "1px solid #000000";
        }
        if (mealDays.value > 31 || mealDays.value < 1) {
            mealDays.style.border = "1px solid red";
            let span = document.createElement("span");
            span.innerHTML = "Please enter a valid number between 1 and 31";
            span.style.color = "red";
            span.style.fontWeight = "bold";
            mealDays.parentNode.appendChild(span);
        }
    });

    function getTaxRate(grossSalary, taxTable) {
        for (let salary in taxTable) {
            if (salary >= grossSalary) {
                return taxTable[salary];
            }
        }
        return 43.8;
    }

    function calculateMealAllowance(
        netSalary,
        grossSalary,
        typeMealAllowance,
        mealAllowance,
        mealDays
    ) {
        let mealAllowanceTaxed = 0;
        if (typeMealAllowance === "no_allowance") {
            return {netSalary: netSalary, grossSalary: grossSalary};
        } else if (typeMealAllowance === "card") {
            if (mealAllowance >= 7.33) {
                mealAllowanceTaxed = mealAllowance - 7.33;
                grossSalary = grossSalary + (mealAllowance - 7.33) * mealDays;
                netSalary = netSalary + 7.33 * mealDays;
            } else {
                netSalary = netSalary + mealAllowance * 22;
            }
        } else if (typeMealAllowance === "money") {
            if (mealAllowance >= 4.57) {
                mealAllowanceTaxed = mealAllowance - 4.57;
                grossSalary = grossSalary + (mealAllowance - 4.57) * mealDays;
                netSalary = netSalary + 4.57 * 22;
            } else {
                netSalary = netSalary + mealAllowance * mealDays;
            }
        }
        return {netSalary: netSalary, grossSalary: grossSalary, mealAllowanceTaxed: mealAllowanceTaxed};
    }

    function calculateNetSalary() {
        let netSalaryTemp = 0;
        let grossSalary = +document.getElementById("base_salary").value;
        let typeMealAllowance = document.getElementById("meal_allowance").value;
        let mealAllowance = +document.getElementById("meal_allowance_amount").value;
        const mealDays = +document.getElementById("meal_days").value;
        const result = calculateMealAllowance(
            netSalaryTemp,
            grossSalary,
            typeMealAllowance,
            mealAllowance,
            mealDays
        );
        netSalaryTemp = result.netSalary;
        grossSalary = result.grossSalary;
        const taxOwed = getTaxRate(grossSalary, taxes);

        const descontos_ss = grossSalary * (11 / 100);
        const descontos_irs = grossSalary * (taxOwed / 100);

        const netSalary =
            grossSalary - descontos_irs - descontos_ss + netSalaryTemp;
        document.getElementById("net_salary").textContent = netSalary.toFixed(2);
        document.getElementById("descontos_irs").textContent =
            descontos_irs.toFixed(2);
        document.getElementById("descontos_ss").textContent =
            descontos_ss.toFixed(2);
        document.getElementById("gross_salary").textContent =
            grossSalary.toFixed(2);
        document.getElementById("taxes").textContent = taxOwed.toFixed(2) + "%";
        document.getElementById("meal_allowance_value").textContent =
            (mealDays * mealAllowance).toFixed(2);
        document.getElementById("meal_allowance_taxed").textContent =
            (result.mealAllowanceTaxed * mealDays).toFixed(2);
    }

    const calculateButton = document.getElementById("calculate");
    calculateButton.addEventListener("click", calculateNetSalary);
});*/
window.addEventListener("load", () => {
    let taxa = {710: 0, 1015:11.3, 1577:17.2, 2109:21.9, 
        5241:32.3, 11384:39.2, 25504:43.8};
    
    let tiporefeicao = document.getElementById("tiporefeicao");
    let valorSub = document.getElementById("valorSub");
    let dias = document.getElementById("dias");
    
    tiporefeicao.addEventListener("change", () =>{
        if (tiporefeicao === "nenhum"){
            valorSub.value = 0;
            dias.value = 0;
            valorSub.disabled = true;
            dias.disabled = true; 
        }else{
            valorSub.disabled = false;
            dias.disabled = false; 
        }
    });
    
    function taxaPorSalario(salarioBase, taxa){
        for(salario in taxa){
            if(salario >= salarioBase){
            return taxa[salario];
            }
        }
        return taxa[25504];
    }
    
    function calcularSubAlimentacao (salarioBase,tipoRefeicao,valorSub, dias){
        if(tipoRefeicao ==="nenhum"){
            return {salarioBase: salarioBase, valorSub: valorSub}
        }
        if(tipoRefeicao === "cartao"){
            if(valorSub > 7.63){
                salarioBase = salarioBase + (valorSub - 7.63) * dias;
                valorSub = 7.63 * dias; 
            }else{
                valorSub= valorSub * dias;
            }
        }
        if(tipoRefeicao === "dinheiro"){
            if(valorSub > 4.77){
                salarioBase = salarioBase + (valorSub - 4.77) * dias;
                valorSub = 4.77 * dias; 
            }else{
                valorSub= valorSub * dias;
            }
        }
        return {salarioBase: salarioBase, valorSub: valorSub};
    }
    
    

    function salarioLiquido(){
        
        let salarioBase = +document.getElementById("base").value;
        let tipoRefeicao = document.getElementById("tiporefeicao").value;
        let valorSub = +document.getElementById("valorSub").value;
        let dias = +document.getElementById("dias").value;
        const totalSubsidio = calcularSubAlimentacao(salarioBase, tipoRefeicao, valorSub, dias);
        salarioBase = totalSubsidio.salarioBase;
        const subTotal = totalSubsidio.valorSub
        const taxaAplicar = taxaPorSalario(salarioBase, taxa);

        const descSS = salarioBase * 0.11;
        const descIRS = salarioBase * (taxaAplicar / 100);
        console.log(salarioBase + subTotal);
        const salarioLiquido = (salarioBase + subTotal) - descIRS - descSS;
        
        document.getElementById("salarioBruto").textContent = salarioBase;
        document.getElementById("impostos").textContent = taxaAplicar;
        document.getElementById("subAlimentacao").textContent = subTotal;
        document.getElementById("descIrs").textContent = descIRS;
        document.getElementById("descSs").textContent = descSS;
        document.getElementById("salarioLiquido").textContent = salarioLiquido;
        

    }
    document.getElementById("salarioButton").addEventListener("click", salarioLiquido);
});
    

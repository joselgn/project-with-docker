var jsBasic = {
    init : function(){
        //$('.sidenav').sidenav();
    },//init
};//jsBasic

var jqxJS = {
    traduzir : function(){
        var localizationobj = {};
        localizationobj.pagergotopagestring = "Ir para a Página:";
        localizationobj.pagershowrowsstring = "Registros por Página:";
        localizationobj.pagerrangestring = " de ";
        localizationobj.pagernextbuttonstring = "Próxima página";
        localizationobj.pagerpreviousbuttonstring = "Página anterior";
        localizationobj.sortascendingstring = "Menor para maior (A-Z)";
        localizationobj.sortdescendingstring = "Maior para menor (Z-A)";
        localizationobj.sortremovestring = "Remover Ordenação";
        localizationobj.firstDay = 1;
        localizationobj.percentsymbol = "%";
        localizationobj.currencysymbol = "R$";
        localizationobj.currencysymbolposition = "before";
        localizationobj.decimalseparator = ",";
        localizationobj.thousandsseparator = ".";
        localizationobj.emptydatastring = "Nenhum registro encontrado.";
        var days = {
            names:  [
                "Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"
            ],
            namesAbbr:  [
                "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"
            ]
        };
        localizationobj.days = days;
        var months = {
            names: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", ""],
            namesAbbr: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez", ""]
        };
        var patterns = {
            d: "d/M/yyyy",
            D: "dddd, dd MMMM, yyyy",
            t: "hh:mm",
            T: "hh:mm:ss",
            f: "dddd, d. MMMM yyyy hh:mm",
            F: "dddd, d. MMMM yyyy hh:mm:ss",
            M: "dd MMMM",
            Y: "MMMM yyyy"
        };
        localizationobj.patterns = patterns;
        localizationobj.months = months;
        localizationobj.todaystring = "Hoje";
        localizationobj.clearstring = "Limpar";
        return localizationobj;
    },//tradutor

};//jqxJS


//Init Script
$(document).ready(function(){
    jsBasic.init();
});//$.function

import{_ as c,o as s,f as n,b as t,F as r,g as i,t as l,p as u,h}from"./app-0e08b8e7.js";const o=a=>(u("data-v-2c91288d"),a=a(),h(),a),p={class:"table-container"},m={class:"table"},g=o(()=>t("thead",null,[t("tr",null,[t("th",null,"#"),t("th",null,"Tanggal"),t("th",null,"Deskripsi"),t("th",null,"Priode"),t("th",null,"Payment method"),t("th",null,"Total"),t("th",null,"Aksi")])],-1)),y=o(()=>t("td",null,"-",-1)),b=["href"],f=o(()=>t("button",{class:"ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"}," Detail ",-1)),k=[f],v={__name:"DataTransaksi",props:{transaksi:Array},setup(a){return(d,D)=>(s(),n("div",p,[t("table",m,[g,t("tbody",null,[(s(!0),n(r,null,i(a.transaksi,(e,_)=>(s(),n("tr",{key:e.id},[t("td",null,l(_+1),1),t("td",null,l(e.tgl_transaksi),1),t("td",null,l(e.description),1),y,t("td",null,l(e.payment_method),1),t("td",null,l(e.amount),1),t("td",null,[t("a",{href:d.route("admin.nav.transaksi.processing.detail",{transactionId:e.id})},k,8,b)])]))),128))])])]))}},I=c(v,[["__scopeId","data-v-2c91288d"]]);export{I as default};

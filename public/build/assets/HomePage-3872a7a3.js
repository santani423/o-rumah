import{G as d,o as t,c as m,w as l,a as s,D as n,Z as b,b as r,f as o,F as p,g as f,l as c}from"./app-0e08b8e7.js";import{S as x}from"./carousel-1722565c.js";import{_ as L}from"./FrontLayout-2bfbfc46.js";import{_ as k}from"./BannerLists-b5db3aa8.js";import{_ as A,M as h,a as v,b as _,c as $}from"./OurFeatures-c5d1169d.js";import{A as j}from"./AgentCard-f990d982.js";import{_ as w}from"./PropertyCard-e6930ec9.js";import"./Navbar-db97468d.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./v-lazy-image-dc8afecb.js";import"./ChevronRightIcon-cbfe6327.js";import"./LinkButton-77398b75.js";import"./PhoneIcon-95e4a6ba.js";import"./MapPinIcon-a3457f9e.js";const B={class:"bg-neutral-700"},O={class:"mx-auto sm:py-8 sm:space-y-6 max-w-7xl"},C={class:"px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12"},U={__name:"HomePage",props:{bannerLists:Object,latestAdsLists:Object,agentLists:Object,frontAdsLists:Object,propertyTypeLists:Object,isLanding:Boolean},setup(e){const u=e,g=d(()=>{var a;return((a=u.latestAdsLists)==null?void 0:a.length)>0}),y=d(()=>{var a;return((a=u.agentLists)==null?void 0:a.length)>0});return(a,N)=>(t(),m(L,null,{default:l(()=>[s(n(b),{title:"Homepage"}),r("div",B,[r("div",O,[s(k,{class:"md:block sm:px-6 lg:px-8","banner-lists":e.bannerLists},null,8,["banner-lists"]),s(A,{class:"px-4 -mt-6 sm:mt-0 sm:px-6 lg:px-8","property-type-lists":e.propertyTypeLists},null,8,["property-type-lists"]),s(h,{class:"px-4 mt-3 sm:mt-0 sm:px-6 lg:px-8"}),s(v,{class:"px-4 py-6 sm:py-0 sm:px-6 lg:px-8",items:e.frontAdsLists},null,8,["items"])])]),r("div",C,[e.isLanding?c("",!0):(t(),o(p,{key:0},[g.value?(t(),m(_,{key:0,title:"Daftar properti terbaru"},{default:l(()=>[(t(!0),o(p,null,f(e.latestAdsLists,i=>(t(),m(n(x),{key:i.id},{default:l(()=>[s(w,{ads:i},null,8,["ads"])]),_:2},1024))),128))]),_:1})):c("",!0),y.value?(t(),m(_,{key:1,title:"Agen pilihan kami",subtitle:"Temukan agen pilihan kami","item-shown":3},{default:l(()=>[(t(!0),o(p,null,f(e.agentLists,i=>(t(),m(n(x),{key:i.id},{default:l(()=>[s(j,{agent:i},null,8,["agent"])]),_:2},1024))),128))]),_:1})):c("",!0)],64)),s($)])]),_:1}))}};export{U as default};

import{G as d,o as s,f as a,a as o,w as m,F as n,D as u,Z as p,l as _,b as t,t as f,g as x,c as h}from"./app-0e08b8e7.js";import{_ as g}from"./FrontLayout-2bfbfc46.js";import{M as b}from"./MobileComingSoon-9fea2f12.js";import{P as k}from"./Pagination-14dedf0e.js";import"./carousel-1722565c.js";import{_ as v}from"./SearchListing-0a3a45ad.js";import{_ as y}from"./PropertyCard-e6930ec9.js";import"./Navbar-db97468d.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./utils-3f1803c0.js";import"./ChevronDownIcon-e8468cd4.js";import"./radio-group-a8a44e10.js";import"./use-controllable-3085494d.js";import"./DefaultButton-07f6876e.js";import"./v-lazy-image-dc8afecb.js";import"./MapPinIcon-a3457f9e.js";const L={key:0,class:"px-4 mx-auto space-y-8 max-w-7xl sm:p-6 lg:p-8"},w={class:"px-4 mx-auto space-y-8 mb-6 max-w-7xl sm:p-6 lg:p-8"},j={key:0,class:"space-y-6"},B={class:"flex md:flex-row md:items-center md:justify-between"},C={class:"flex flex-col gap-1"},F=t("span",{class:"text-xl font-medium text-neutral-900"},"Tenant OFoods",-1),O={class:"text-neutral-500"},D=t("div",{class:"flex justify-end"},[t("select",{id:"sort",name:"sort",class:"pl-4 border rounded-full border-neutral-200 text-neutral-900 focus:ring-0 focus:ring-transparent focus:border-neutral-200"},[t("option",{selected:""},"Diutamakan"),t("option",null,"Terbaru")])],-1),N={class:"grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-x-6 gap-y-12"},P={key:1},T=t("div",{class:"text-center"},[t("div",{class:"text-lg font-medium text-neutral-900"}," Tidak ada merchant ditemukan ")],-1),V=[T],$=t("div",{class:"px-4 mx-auto space-y-8 mb-6 max-w-7xl sm:p-6 lg:p-8"},null,-1),at={__name:"LatestPage",props:{adsLists:Object,bannerLists:Object},setup(i){const l=i;console.log("ceek",l.adsLists.data);const c=d(()=>{var e;return((e=l.adsLists)==null?void 0:e.data.length)>0});return(e,A)=>(s(),a(n,null,[o(b),o(g,null,{default:m(()=>[o(u(p),{title:"OFoods"}),e.bannerAvailable?(s(),a("div",L)):_("",!0),o(v,{class:"-mt-1.5","current-url":e.route("omerchant"),"search-placeholder":"Cari merchant","is-full-width":"","hide-filter":""},null,8,["current-url"]),t("div",w,[c.value?(s(),a("div",j,[t("div",B,[t("div",C,[F,t("span",O,f(i.adsLists.total)+" tenant ditemukan",1)]),D]),t("div",N,[(s(!0),a(n,null,x(i.adsLists.data,r=>(s(),h(y,{key:r.id,ads:r},null,8,["ads"]))),128))])])):(s(),a("div",P,V)),o(k,{class:"mx-auto",links:i.adsLists.links},null,8,["links"])]),$]),_:1})],64))}};export{at as default};

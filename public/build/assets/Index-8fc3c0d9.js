import{r as n,o as d,c as l,w as p,a as i,b as e,d as c,e as m,v as u}from"./app-0e08b8e7.js";import b from"./ListingLayout-58f35458.js";import h from"./DataProvince-6fa22953.js";import"./Navbar-db97468d.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./MemberSeedebar-4e08d915.js";const v={class:"pb-36"},f={class:"bg-white shadow-md rounded-lg p-4"},y={class:"flex items-center justify-between border-b border-gray-300 pb-4 mb-4"},_=e("h3",{class:"text-xl font-semibold text-gray-800"},"Kota",-1),x=e("button",{type:"submit",class:"ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"}," Cari ",-1),j={__name:"Index",props:{idprovinces:Array},setup(r){return console.log("Received bank:",r),(o,t)=>{const a=n("Head");return d(),l(b,null,{default:p(()=>[i(a,{title:"Dashboard"}),e("div",v,[e("div",f,[e("div",y,[_,e("form",{onSubmit:t[1]||(t[1]=c((...s)=>o.search&&o.search(...s),["prevent"])),class:"flex items-center"},[m(e("input",{"onUpdate:modelValue":t[0]||(t[0]=s=>o.searchQuery=s),type:"text",class:"w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none",placeholder:"Cari..."},null,512),[[u,o.searchQuery]]),x],32)]),e("div",null,[i(h,{idprovinces:r.idprovinces},null,8,["idprovinces"])])])])]),_:1})}}};export{j as default};

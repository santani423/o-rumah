import{r as i,o as d,c as l,w as p,a,b as e,d as m,e as c,v as b}from"./app-0e08b8e7.js";import u from"./ListingLayout-58f35458.js";import h from"./DataBank-5ddcce15.js";import"./Navbar-db97468d.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./MemberSeedebar-4e08d915.js";const f={class:"pb-36"},y={class:"bg-white shadow-md rounded-lg p-4"},_={class:"flex items-center justify-between border-b border-gray-300 pb-4 mb-4"},v=e("h3",{class:"text-xl font-semibold text-gray-800"},"Bank",-1),x=e("button",{type:"submit",class:"ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"}," Cari ",-1),j={__name:"Index",props:{bank:Array},setup(r){return console.log("Received bank:",r),(t,o)=>{const n=i("Head");return d(),l(u,null,{default:p(()=>[a(n,{title:"Dashboard"}),e("div",f,[e("div",y,[e("div",_,[v,e("form",{onSubmit:o[1]||(o[1]=m((...s)=>t.search&&t.search(...s),["prevent"])),class:"flex items-center"},[c(e("input",{"onUpdate:modelValue":o[0]||(o[0]=s=>t.searchQuery=s),type:"text",class:"w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none",placeholder:"Cari..."},null,512),[[b,t.searchQuery]]),x],32)]),e("div",null,[a(h,{bank:r.bank},null,8,["bank"])])])])]),_:1})}}};export{j as default};

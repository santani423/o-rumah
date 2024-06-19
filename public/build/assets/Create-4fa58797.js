import{B as d,C as B,r as M,o as c,c as m,w as g,a as l,D as b,Z as V,b as a,d as C,l as h,n as w,e as F,v as I,i as j,O as x}from"./app-0e08b8e7.js";import{_ as D}from"./Card-af735f35.js";import E from"./FormInput-e6e810e2.js";import{_ as u}from"./Navbar-db97468d.js";import{e as S}from"./vue3-simple-typeahead-0d6d51e4.js";import U from"./ListingLayout-58f35458.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./MemberSeedebar-4e08d915.js";const A={class:"mx-auto space-y-6 max-w-7xl"},O=a("div",{class:"flex items-center justify-between"},[a("div",null,[a("h4",{class:"text-lg font-bold"},"Buat Iklan Food Anda!"),a("p",{class:"text-sm font-normal"}," Silahkan cari alamat terlebih dahulu. ")])],-1),N={class:"w-full"},$={class:"mb-3"},G={class:"mb-3"},K={class:"mb-3"},z=a("p",{class:"mb-3 text-sm font-medium"}," Alamat Lengkap ",-1),P={class:"flex justify-end my-3"},T=["disabled"],st={__name:"Create",props:{errors:Object,id:Number,isUpdate:Boolean,data:Object,url:Object},setup(o){var n=o;const p=d({districtList:[]}),t=d({district:null,districtId:null,districtLocation:null,kawasan:null,alamat:null});B(()=>{var s,e;if(n.isUpdate){const r=n.data;t.district=r.district,t.districtId=r.districtId,t.districtLocation={lat:parseFloat((s=r.districtLocation)==null?void 0:s.lat),long:parseFloat((e=r.districtLocation)==null?void 0:e.long)},t.kawasan=r.kawasan,t.alamat=r.alamat}});const _=s=>s.name,v=s=>{var e=route("listing.getDistrict",{name:s});j({method:"get",url:e}).then(r=>{p.districtList=d(r.data)})},L=s=>{t.district=s.name,t.districtId=s.id,t.districtLocation={lat:parseFloat(s.meta.lat),long:parseFloat(s.meta.long)}},y=()=>{if(n.isUpdate==!0){x.get(route("listing.edit",n.id),t,{preserveState:!0});return}x.get(route("member.food.store-listing"),t,{preserveState:!0})};return(s,e)=>{const r=M("GMapMap");return c(),m(U,null,{default:g(()=>[l(b(V),{title:"Iklankan Food"}),a("div",A,[O,a("div",null,[a("form",{onSubmit:C(y,["prevent"])},[l(D,{"card-title":"Lokasi"},{default:g(()=>{var f,k;return[a("div",N,[a("div",$,[l(b(S),{id:"typeahead_id",placeholder:"Masukkan Kecamatan...",items:p.districtList,minInputLength:1,itemProjection:_,onKeyup:e[0]||(e[0]=i=>v(i.target.value)),onSelectItem:L,class:"w-full text-sm rounded-md shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 placeholder:text-sm",modelValue:t.district,"onUpdate:modelValue":e[1]||(e[1]=i=>t.district=i),value:t.district??""},null,8,["items","modelValue","value"]),o.errors.district?(c(),m(u,{key:0,class:"mt-2",message:o.errors.district},null,8,["message"])):h("",!0)]),a("div",{class:w(["w-full mb-3",{hidden:!t.districtLocation}])},[l(r,{center:{lat:((f=t.districtLocation)==null?void 0:f.lat)??0,lng:((k=t.districtLocation)==null?void 0:k.long)??0},zoom:15,"map-type-id":"terrain",style:{width:"100%",height:"400px"}},null,8,["center"])],2),a("div",G,[l(E,{title:"Area/Kawasan",placeholder:"Masukkan nama area atau kawasan",id:"kawasan",modelValue:t.kawasan,"onUpdate:modelValue":e[2]||(e[2]=i=>t.kawasan=i)},null,8,["modelValue"]),o.errors.kawasan?(c(),m(u,{key:0,class:"mt-2",message:o.errors.kawasan},null,8,["message"])):h("",!0)]),a("div",K,[z,F(a("textarea",{class:"w-full text-sm rounded-md shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 placeholder:text-sm",rows:"4",placeholder:"Masukkan alamat lengkap","onUpdate:modelValue":e[3]||(e[3]=i=>t.alamat=i)},null,512),[[I,t.alamat]]),l(u,{class:"mt-2",message:o.errors.alamat},null,8,["message"])])])]}),_:1}),a("div",P,[a("button",{type:"submit",class:w(["bg-[#1CD6D0] disabled:bg-[#EAEBF0] disabled:text-[#B1B2CE] text-white py-2 px-4 rounded-md",{"bg-[#EAEBF0]":t.processing,"text-[#B1B2CE]":t.processing}]),disabled:t.processing}," Gunakan Lokasi ",10,T)])],32)])])]),_:1})}}};export{st as default};

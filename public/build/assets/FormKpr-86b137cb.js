import{_ as P,j as d,o as l,c as L,w as D,a as R,D as G,Z as H,b as e,t as c,d as M,f as s,g,F as f,e as k,N as y,l as h,m as $,i as T,p as V,h as J}from"./app-0e08b8e7.js";import{_ as z}from"./FrontLayout-2bfbfc46.js";import{A as O}from"./AgentCard-f990d982.js";import"./vue-select-05f4beb1.js";import"./Navbar-db97468d.js";import"./Divider-ce31086d.js";import"./description-8ebb68a9.js";import"./transition-95532faa.js";import"./use-tree-walker-a6b88a9a.js";import"./Footer-1cc72079.js";import"./LinkButton-77398b75.js";import"./PhoneIcon-95e4a6ba.js";const n=r=>(V("data-v-fb71a75c"),r=r(),J(),r),Z={class:"container mx-auto px-4 sm:px-6 lg:px-8 my-8"},q={class:"flex justify-center"},Q={class:"bg-white p-8 border border-neutral-200 rounded-3xl shadow-lg w-full max-w-4xl mr-3",style:{"min-height":"100%"}},W={class:"text-xl text-gray-700 mb-4 font-bold"},X={class:"text-3xl font-bold text-teal-500 mb-6"},Y=["src"],ee={class:"bg-white p-8 border border-neutral-200 rounded-3xl shadow-lg w-full max-w-4xl"},te=n(()=>e("p",{class:"text-xl text-gray-700 mb-4 font-bold"}," Formulir Pengajuan KPR ",-1)),ae={class:"grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"},oe=n(()=>e("label",{for:"bankUmum",class:"block text-sm font-medium text-gray-700"},"Bank Umum:",-1)),le={id:"bankUmum",class:"w-full p-3 border border-gray-300 rounded-md"},ne=n(()=>e("option",{disabled:"",selected:""}," Pilih Bank Umum ",-1)),se=["label"],ie=["value"],re=n(()=>e("label",{for:"bankBpr",class:"block text-sm font-medium text-gray-700"},"Bank BPR:",-1)),de={id:"bankBpr",class:"w-full p-3 border border-gray-300 rounded-md"},ue=n(()=>e("option",{disabled:"",selected:""}," Pilih Bank BPR ",-1)),ce=["label"],me=["value"],pe={class:"grid grid-cols-1 md:grid-cols-3 gap-4 mb-4"},ge=n(()=>e("h3",{class:"col-span-3 text-left"}," Pilih Pekerjaan: ",-1)),fe=["for"],ke=["id","value"],he=n(()=>e("div",{class:"grid grid-cols-1 md:grid-cols-1 gap-4 mb-4"},[e("div",null,[e("label",{for:"namaLengkap",class:"block text-sm font-medium text-gray-700"},"Nama Lengkap:"),e("input",{type:"text",id:"namaLengkap",placeholder:"Masukkan Nama Lengkap Anda",class:"w-full p-3 border border-gray-300 rounded-md"})])],-1)),be=n(()=>e("div",{class:"grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"},[e("div",null,[e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"Email:"),e("input",{type:"email",id:"email",placeholder:"Masukkan Email Anda",class:"w-full p-3 border border-gray-300 rounded-md"})]),e("div",null,[e("label",{for:"noHp",class:"block text-sm font-medium text-gray-700"},"No Handphone:"),e("input",{type:"tel",id:"noHp",placeholder:"Masukkan No Handphone Anda",class:"w-full p-3 border border-gray-300 rounded-md"})])],-1)),_e={class:"mb-4"},ve=n(()=>e("label",{for:"foto",class:"block text-sm font-medium text-gray-700"},"Upload Foto KTP Pemohon/Suami/Istri:",-1)),ye=["src"],xe={key:0,class:"text-center text-gray-500"},we={class:"mb-4"},Se=n(()=>e("label",{for:"fotokk",class:"block text-sm font-medium text-gray-700"},"Upload Foto Kartu Keluarga:",-1)),Be=["src"],Ke={key:0,class:"text-center text-gray-500"},je={class:"mb-4"},Re=n(()=>e("label",{for:"fotoSuratNikah",class:"block text-sm font-medium text-gray-700"},"Upload Foto Surat Nikah atau Cerai:",-1)),Ie=["src"],Ce={key:0,class:"text-center text-gray-500"},Ue={class:"mb-4"},Fe=n(()=>e("label",{for:"fotoRekeningKoran",class:"block text-sm font-medium text-gray-700"},"Upload Rekening Koran 3 Bulan Terakhir:",-1)),Ne={id:"imgfotoRekeningKoran",src:"/assets/icons/paper-icon.png",class:"mt-4 max-w-full h-auto",style:{display:"none",width:"50px",height:"50px"}},Ae={key:0,class:"text-center text-gray-500"},Ee={class:"mb-4"},Pe=n(()=>e("label",{for:"fotoSlipGaji",class:"block text-sm font-medium text-gray-700"},"Upload Slip Gaji:",-1)),Le={key:0,class:"text-center text-gray-500"},De={key:1,class:"flex items-center gap-2 mt-4"},Ge=n(()=>e("img",{src:"/assets/icons/paper-icon.png",alt:"File Icon",style:{width:"50px",height:"50px"}},null,-1)),He={class:"mb-4"},Me=n(()=>e("label",{for:"agreement",class:"text-sm font-medium text-gray-700"}," Saya menyatakan bahwa dokumen dipercayakan kepada ORumah untuk dipergunakan proses pengajuan BI checking/KPR untuk dipergunakan seperlunya. ",-1)),$e={key:0,class:"fixed inset-0 bg-black bg-opacity-50 z-50"},Te=n(()=>e("h2",{class:"text-lg font-bold"}," Kebijakan Persetujuan ",-1)),Ve=n(()=>e("p",null," Detail kebijakan persetujuan akan dijelaskan di sini... ",-1)),Je=n(()=>e("div",{class:"flex justify-end mt-6"},[e("button",{type:"submit",class:"bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded-md"}," Kirim ")],-1)),ze={__name:"FormKpr",props:{ads:Array,job:Array,agent:Array,bankBpr:Array,bankUmum:Array},setup(r){const m=d(""),b=d(""),_=d(""),x=d(""),w=d(""),S=d(""),B=r,v=d(!1),K=d(!1);function j(){K.value=!K.value}function I(o){S.value=o.target.value,console.log("Pekerjaan yang dipilih: ",S.value)}console.log("props",B.bankBpr);function C(o){const[t]=o.target.files;if(t){const a=new FileReader;a.onload=i=>{m.value=i.target.result},a.readAsDataURL(t)}}function U(o){const[t]=o.target.files;if(console.log("ini"),t){const a=new FileReader;a.onload=i=>{b.value=i.target.result},a.readAsDataURL(t)}}function F(o){const[t]=o.target.files;if(console.log("ini"),t){const a=new FileReader;a.onload=i=>{_.value=i.target.result},a.readAsDataURL(t)}}function N(o){const[t]=o.target.files;if(console.log("ini"),t){const a=new FileReader;a.onload=i=>{x.value=i.target.result},a.readAsDataURL(t)}}function A(o){const[t]=o.target.files;if(console.log("ini"),t){const a=new FileReader;a.onload=i=>{w.value=i.target.result},a.readAsDataURL(t)}}function p(o){const t=document.getElementById(o);t?t.click():console.error(`Input element with id ${o} not found`)}const E=()=>{if(!v.value){alert("Anda harus menyetujui persyaratan untuk melanjutkan.");return}const o=new FormData;o.append("imageSrc",document.getElementById("foto").files[0]),o.append("imagekkSrc",document.getElementById("fotokk").files[0]),o.append("fotoSuratNikahSrc",document.getElementById("fotoSuratNikah").files[0]),o.append("fotoRekeningKoranSrc",document.getElementById("fotoRekeningKoran").files[0]),o.append("fotoSlipGajiSrc",document.getElementById("fotoSlipGaji").files[0]),o.append("bankUmum",document.getElementById("bankUmum").value),o.append("bankBpr",document.getElementById("bankBpr").value),o.append("pekerjaan",S.value),o.append("agreement",v.value),console.log("ok"),o.append("ads_id",B.ads.ads_id),o.append("namaLengkap",document.getElementById("namaLengkap").value),o.append("email",document.getElementById("email").value),o.append("noHp",document.getElementById("noHp").value),console.log(o),T.post(route("linkKpr.store",B.ads.slug),o,{headers:{"Content-Type":"multipart/form-data"}}).then(t=>{console.log("Response from Laravel:",t.data),window.location.href=route("member.pengajuan.kpr")}).catch(t=>{console.error("Error submitting form:",t)})};return(o,t)=>(l(),L(z,null,{default:D(()=>[R(G(H),{title:"Formulir Pengajuan KPR"}),e("div",Z,[e("div",q,[e("div",Q,[e("p",W,c(r.ads.title),1),e("h3",X," Harga: Rp"+c(r.ads.price),1),e("img",{src:r.ads.image,alt:"Deskripsi Gambar",class:"max-w-full mb-3"},null,8,Y),R(O,{agent:r.agent,slug:r.ads.slug,"show-stats":!1,showKpr:!1},null,8,["agent","slug"])]),e("div",ee,[te,e("form",{class:"w-full",onSubmit:M(E,["prevent"]),enctype:"multipart/form-data"},[e("div",ae,[e("div",null,[oe,e("select",le,[ne,(l(!0),s(f,null,g(r.bankUmum,(a,i)=>(l(),s("optgroup",{label:i},[(l(!0),s(f,null,g(a.banks,u=>(l(),s("option",{key:u.id,value:u.id},c(u.alias_name),9,ie))),128))],8,se))),256))])]),e("div",null,[re,e("select",de,[ue,(l(!0),s(f,null,g(r.bankBpr,(a,i)=>(l(),s("optgroup",{label:i},[(l(!0),s(f,null,g(a.banks,u=>(l(),s("option",{key:u.id,value:u.id},c(u.alias_name),9,me))),128))],8,ce))),256))])])]),e("div",pe,[ge,(l(!0),s(f,null,g(r.job,(a,i)=>(l(),s("div",{class:"bg-white p-4 shadow rounded-lg flex justify-between items-center",key:a.id},[e("label",{for:"option"+a.id,class:"text-left"},c(a.title),9,fe),e("input",{type:"radio",id:"option"+a.id,name:"pekerjaan",value:a.id,class:"text-right",onChange:I},null,40,ke)]))),128))]),he,be,e("div",_e,[ve,e("div",{class:"p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer",onClick:t[1]||(t[1]=a=>p("foto"))},[e("input",{type:"file",id:"foto",onChange:t[0]||(t[0]=a=>C(a,m.value)),class:"w-full p-3 hidden"},null,32),k(e("img",{id:"suamiIstri",src:m.value,class:"mt-4 max-w-full h-auto",style:{display:"none"}},null,8,ye),[[y,m.value]]),m.value?h("",!0):(l(),s("div",xe," Klik untuk mengupload gambar "))])]),e("div",we,[Se,e("div",{class:"p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer",onClick:t[2]||(t[2]=a=>p("fotokk"))},[e("input",{type:"file",id:"fotokk",onChange:U,class:"w-full p-3 hidden"},null,32),k(e("img",{id:"kartuKeluarga",src:b.value,class:"mt-4 max-w-full h-auto",style:{display:"none"}},null,8,Be),[[y,b.value]]),b.value?h("",!0):(l(),s("div",Ke," Klik untuk mengupload gambar "))])]),e("div",je,[Re,e("div",{class:"p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer",onClick:t[3]||(t[3]=a=>p("fotoSuratNikah"))},[e("input",{type:"file",id:"fotoSuratNikah",onChange:F,class:"w-full p-3 hidden"},null,32),k(e("img",{id:"imgfotoSuratNikah",src:_.value,class:"mt-4 max-w-full h-auto",style:{display:"none"}},null,8,Ie),[[y,_.value]]),_.value?h("",!0):(l(),s("div",Ce," Klik untuk mengupload gambar "))])]),e("div",Ue,[Fe,e("div",{class:"p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer",onClick:t[4]||(t[4]=a=>p("fotoRekeningKoran"))},[e("input",{type:"file",id:"fotoRekeningKoran",onChange:N,class:"w-full p-3 hidden"},null,32),k(e("img",Ne,null,512),[[y,x.value]]),x.value?h("",!0):(l(),s("div",Ae," Klik untuk mengupload gambar "))])]),e("div",Ee,[Pe,e("div",{class:"p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer",onClick:t[5]||(t[5]=a=>p("fotoSlipGaji"))},[e("input",{type:"file",id:"fotoSlipGaji",onChange:A,class:"w-full p-3 hidden"},null,32),w.value?(l(),s("div",De,[Ge,e("span",null,c(w.value.name),1)])):(l(),s("div",Le," Klik atau seret file ke sini untuk mengupload "))])]),e("div",He,[k(e("input",{type:"checkbox",id:"agreement","onUpdate:modelValue":t[6]||(t[6]=a=>v.value=a),class:"mr-2"},null,512),[[$,v.value]]),Me,e("a",{href:"#",onClick:j,class:"text-blue-500 hover:text-blue-700 text-sm ml-2"}," Baca lebih lanjut ")]),K.value?(l(),s("div",$e,[e("div",{class:"flex justify-center items-center h-full"},[e("div",{class:"bg-white p-5 rounded-lg"},[Te,Ve,e("button",{onClick:j,class:"mt-3 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"}," Tutup ")])])])):h("",!0),Je],32)])])])]),_:1}))}},nt=P(ze,[["__scopeId","data-v-fb71a75c"]]);export{nt as default};

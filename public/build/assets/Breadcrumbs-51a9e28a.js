import{o as a,f as t,b as e,a as s,w as i,D as n,E as c,F as u,g as d,t as h}from"./app-0e08b8e7.js";import{r as f}from"./ChevronRightIcon-cbfe6327.js";function m(l,o){return a(),t("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z","clip-rule":"evenodd"})])}const _={class:"flex","aria-label":"Breadcrumb"},x={role:"list",class:"flex items-center space-x-4"},p=e("span",{class:"sr-only"},"Halaman Utama",-1),v={class:"flex items-center"},w=["href","aria-current"],y={__name:"Breadcrumbs",props:{pages:{type:Array,default:()=>[{name:"Properti Baru",href:route("latest"),current:!0}]}},setup(l){return(o,B)=>(a(),t("nav",_,[e("ol",x,[e("li",null,[e("div",null,[s(n(c),{href:o.route("home"),class:"text-neutral-400 hover:text-neutral-500"},{default:i(()=>[s(n(m),{class:"flex-shrink-0 w-6 h-6","aria-hidden":"true"}),p]),_:1},8,["href"])])]),(a(!0),t(u,null,d(l.pages,r=>(a(),t("li",{key:r.name},[e("div",v,[s(n(f),{class:"flex-shrink-0 w-6 h-6 text-neutral-400","aria-hidden":"true"}),e("a",{href:r.href,class:"ml-4 font-medium text-neutral-500 hover:text-neutral-700","aria-current":r.current?"page":void 0},h(r.name),9,w)])]))),128))])]))}};export{y as _};

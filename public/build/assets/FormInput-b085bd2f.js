import{j as n,o as d,f as s,b as l,t as i}from"./app-0e08b8e7.js";const c={class:"block"},m={class:"mb-3 text-sm font-medium"},p=["id","type","placeholder","value"],g={__name:"FormInput",props:{id:String,title:String,placeholder:String,type:String,modelValue:String},emits:["update:modelValue"],setup(e,{expose:a}){const r=n(null);return a({focus:()=>r.value.focus()}),(o,t)=>(d(),s("div",c,[l("p",m,i(e.title),1),l("input",{id:e.id,type:e.type,placeholder:e.placeholder,class:"border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 rounded-md shadow-sm w-full placeholder:text-sm text-sm",autocomplete:"",value:e.modelValue,onInput:t[0]||(t[0]=u=>o.$emit("update:modelValue",u.target.value))},null,40,p)]))}};export{g as default};

const $tbody=document.querySelector(".table tbody"),$trTemplate=document.getElementById("table-row").content;fetch("api/post").then(e=>e.ok?e.json():Promise.reject(e)).then(e=>{const t=document.createDocumentFragment();e.forEach(e=>{const o=$trTemplate.cloneNode(!0);o.querySelector(".title").textContent=e.title,o.querySelector(".thumbnail").textContent="http://localhost:3000/assets/thumbnails/"+e.thumbnail.all,o.querySelector(".edit").href="/admin/update?id="+e.id,o.querySelector(".delete").dataset.id=e.id,t.appendChild(o)}),$tbody.appendChild(t)}).catch(e=>console.log(e)),document.addEventListener("click",e=>{e.target.matches(".delete")&&sendAlert({title:"Warning!!!",text:"Esta seguro de que desea Eliminar este post??",cb:()=>{const t=new FormData;t.append("id",e.target.dataset.id),fetch("/admin",{method:"POST",body:t}),location.reload()}})});
import { W as attr, X as attr_class, V as ensure_array_like, $ as clsx } from "../../chunks/index2.js";
import { p as projects } from "../../chunks/sample-data.js";
import { e as escape_html } from "../../chunks/context.js";
function _page($$renderer, $$props) {
  $$renderer.component(($$renderer2) => {
    let filteredProjects;
    const cloneProjects = () => projects.map((project) => ({ ...project }));
    let projects$1 = cloneProjects();
    let searchQuery = "";
    let viewMode = "grid";
    const viewClasses = {
      grid: "grid grid-cols-1 lg:grid-cols-4 gap-4",
      list: "space-y-2"
    };
    filteredProjects = projects$1.filter((project) => {
      return true;
    });
    $$renderer2.push(`<div class="flex w-full"><div class="flex bg-black w-full"><div class="p-6 w-full"><div class="mb-6 w-full"><div class="flex items-center gap-5 justify-between w-full"><div class="flex-1 relative"><input type="text"${attr("value", searchQuery)} placeholder="Search Projects..." class="w-full pl-10 pr-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500"/> <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i></div> <div class="flex gap-0 border border-gray-800 rounded-lg overflow-hidden"><button${attr_class(`px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800 ${"bg-gray-800 text-white"}`)} aria-label="Grid view"><i class="fas fa-th text-sm"></i></button> <button${attr_class(`px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800 ${"bg-black"}`)} aria-label="List view"><i class="fas fa-list text-sm"></i></button></div> <div class="relative"><button class="bg-white text-black px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2"><span>Add New...</span> <i class="fas fa-chevron-down text-xs"></i></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div></div></div> <div class="mb-6"><h2 class="text-xl font-semibold text-white">Projects</h2></div> `);
    if (!projects$1.length) {
      $$renderer2.push("<!--[-->");
      $$renderer2.push(`<div class="flex flex-col items-center justify-center py-20"><div class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4"><i class="fas fa-folder-open text-gray-600 text-2xl"></i></div> <h3 class="text-lg font-medium text-white mb-2">No projects yet</h3> <p class="text-gray-400 text-sm mb-6">Get started by deploying your first project</p> <button class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"><i class="fas fa-plus mr-2"></i>New Project</button></div>`);
    } else {
      $$renderer2.push("<!--[!-->");
      if (filteredProjects.length === 0 && searchQuery) ;
      else {
        $$renderer2.push("<!--[!-->");
      }
      $$renderer2.push(`<!--]--> `);
      if (filteredProjects.length > 0) {
        $$renderer2.push("<!--[-->");
        $$renderer2.push(`<div${attr_class(clsx(viewClasses[viewMode]))}><!--[-->`);
        const each_array = ensure_array_like(filteredProjects);
        for (let $$index = 0, $$length = each_array.length; $$index < $$length; $$index++) {
          let project = each_array[$$index];
          $$renderer2.push(`<a${attr("href", `/project/${project.slug}`)}${attr_class(`bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700 transition-all cursor-pointer ${""}`)}><div${attr_class(clsx("p-5"))}><div${attr_class(`${"flex items-start justify-between mb-4"}`)}><div class="flex items-center gap-3 flex-1 min-w-0"><div class="w-10 h-10 bg-white rounded flex items-center justify-center flex-shrink-0"><i class="fas fa-triangle text-black text-xs"></i></div> <div class="flex-1 min-w-0"><h3 class="font-semibold text-white text-sm mb-1 truncate">${escape_html(project.name)}</h3> <p class="text-xs text-gray-500 truncate">${escape_html(project.url.replace("https://", ""))}</p></div></div> <div${attr_class(`${"flex items-center gap-2"}`)}>`);
          {
            $$renderer2.push("<!--[-->");
            $$renderer2.push(`<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors" aria-label="View metrics"><i class="fas fa-chart-line text-sm"></i></button>`);
          }
          $$renderer2.push(`<!--]--> <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors" aria-label="Open project menu"><i class="fas fa-ellipsis-h text-sm"></i></button></div></div> `);
          {
            $$renderer2.push("<!--[-->");
            $$renderer2.push(`<div><div class="flex items-center gap-2 text-xs text-gray-400 mb-3"><i class="fab fa-github"></i> <span>${escape_html(project.githubRepo ?? "No repository")}</span></div> <div class="flex items-center gap-2 mb-2"><div${attr_class(`w-2 h-2 rounded-full ${project.status === "Ready" ? "bg-green-500" : "bg-yellow-500"}`)}></div> <p class="text-sm text-gray-300">${escape_html(project.status)}</p></div> <div class="flex items-center gap-2 text-xs text-gray-500"><span>${escape_html(project.updatedAtHuman)}</span> <span>on</span> <i class="fas fa-code-branch text-[10px]"></i> <span>${escape_html(project.branch || "main")}</span></div></div>`);
          }
          $$renderer2.push(`<!--]--></div></a>`);
        }
        $$renderer2.push(`<!--]--></div>`);
      } else {
        $$renderer2.push("<!--[!-->");
      }
      $$renderer2.push(`<!--]-->`);
    }
    $$renderer2.push(`<!--]--></div></div></div> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]-->`);
  });
}
export {
  _page as default
};

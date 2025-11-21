import { V as ensure_array_like, W as attr, X as attr_class } from "../../../chunks/index2.js";
import { d as deployments } from "../../../chunks/sample-data.js";
import { e as escape_html } from "../../../chunks/context.js";
function _page($$renderer, $$props) {
  $$renderer.component(($$renderer2) => {
    let filteredDeployments;
    const allDeployments = deployments.map((deployment) => ({ ...deployment }));
    Array.from(new Set(allDeployments.map((deployment) => deployment.author)));
    Array.from(new Set(allDeployments.map((deployment) => deployment.environment)));
    filteredDeployments = allDeployments.filter((deployment) => {
      return true;
    });
    $$renderer2.push(`<div class="mx-auto px-6 py-8"><div class="mb-8"><h1 class="text-3xl font-bold mb-2">Deployments</h1> <p class="text-sm text-gray-400">All deployments from <span class="font-mono text-white">all projects</span></p></div> <div class="flex items-center gap-4 mb-6 flex-wrap"><div class="relative"><button class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"><i class="far fa-calendar"></i> <span>${escape_html("Select Date Range")}</span></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div> <div class="relative"><button class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"><i class="fas fa-user"></i> <span>${escape_html("All Authors...")}</span> <i class="fas fa-chevron-down text-xs"></i></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div> <div class="relative"><button class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"><span>${escape_html("All Environments")}</span> <i class="fas fa-chevron-down text-xs"></i></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div> <div class="relative"><button class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"><div class="flex items-center gap-1"><div class="w-2 h-2 bg-red-500 rounded-full"></div> <div class="w-2 h-2 bg-green-500 rounded-full"></div></div> <span>Status ${escape_html(filteredDeployments.length)}/${escape_html(allDeployments.length)}</span> <i class="fas fa-chevron-down text-xs"></i></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div></div> <div class="space-y-0 border border-gray-800 rounded-lg overflow-hidden">`);
    if (filteredDeployments.length === 0) {
      $$renderer2.push("<!--[-->");
      $$renderer2.push(`<div class="px-6 py-12 text-center"><div class="text-gray-500 mb-4"><i class="fas fa-filter text-4xl"></i></div> <p class="text-gray-400">No deployments found</p> <p class="text-sm text-gray-600 mt-1">Try adjusting your filters</p></div>`);
    } else {
      $$renderer2.push("<!--[!-->");
      $$renderer2.push(`<!--[-->`);
      const each_array_4 = ensure_array_like(filteredDeployments);
      for (let $$index_4 = 0, $$length = each_array_4.length; $$index_4 < $$length; $$index_4++) {
        let deployment = each_array_4[$$index_4];
        $$renderer2.push(`<a${attr("href", `/project/${deployment.project.slug}`)}><div class="border-b border-gray-800 last:border-b-0 hover:bg-gray-900/50 transition-colors"><div class="px-6 py-4 flex items-center gap-6"><div class="flex-shrink-0 w-32"><div class="flex items-center gap-2"><div${attr_class(`w-2 h-2 rounded-full ${deployment.status === "Ready" ? "bg-green-500" : deployment.status === "Building" ? "bg-yellow-500" : "bg-red-500"}`)}></div> <span class="text-sm text-gray-400">${escape_html(deployment.status)}</span></div> <div class="text-xs text-gray-500 mt-1">${escape_html(deployment.deploymentId)}</div> <div class="text-xs text-gray-600 mt-0.5">${escape_html(deployment.environment)} <i class="fas fa-circle text-[4px] align-middle mx-1"></i> `);
        if (deployment.isCurrent) {
          $$renderer2.push("<!--[-->");
          $$renderer2.push(`<span class="text-blue-400">Current</span>`);
        } else {
          $$renderer2.push("<!--[!-->");
        }
        $$renderer2.push(`<!--]--></div></div> <div class="flex-shrink-0 w-24 text-xs text-gray-500">${escape_html(deployment.timeFormatted)}</div> <div class="flex-1 min-w-0"><div class="flex items-center gap-3"><div class="w-6 h-6 bg-white rounded flex items-center justify-center flex-shrink-0"><i class="fas fa-triangle text-black text-[8px]"></i></div> <div class="min-w-0"><div class="text-sm font-medium text-white truncate">${escape_html(deployment.project.name)}</div></div></div> <div class="flex items-center gap-3 mt-2 text-xs text-gray-400"><div class="flex items-center gap-1"><i class="fas fa-code-branch text-[10px]"></i> <span>${escape_html(deployment.branch)}</span></div> <div class="flex items-center gap-1"><i class="fas fa-dot-circle text-[8px]"></i> <span>${escape_html(deployment.commitHash)}</span> <span class="text-gray-600">${escape_html(deployment.commitMessage)}</span></div></div></div> <div class="flex-shrink-0 text-right"><div class="text-sm text-gray-400">${escape_html(deployment.deployedAtHuman)}</div> <div class="text-xs text-gray-600 mt-1">by <span>${escape_html(deployment.author)}</span></div></div> <div class="flex-shrink-0"><button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-800 transition-colors text-gray-400" aria-label="Open deployment menu"><i class="fas fa-ellipsis-h"></i></button></div></div></div></a>`);
      }
      $$renderer2.push(`<!--]-->`);
    }
    $$renderer2.push(`<!--]--></div></div>`);
  });
}
export {
  _page as default
};

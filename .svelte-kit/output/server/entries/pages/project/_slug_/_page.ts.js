import { error } from "@sveltejs/kit";
import { p as projects } from "../../../../chunks/sample-data.js";
const load = ({ params }) => {
  const project = projects.find((item) => item.slug === params.slug);
  if (!project) {
    throw error(404, "Project not found");
  }
  return { project };
};
export {
  load
};

import { error } from '@sveltejs/kit';
import { projects } from '$lib/data/sample-data';
import type { PageLoad } from './$types';

export const load: PageLoad = ({ params }) => {
    const project = projects.find((item) => item.slug === params.slug);

    if (!project) {
        throw error(404, 'Project not found');
    }

    return { project };
};


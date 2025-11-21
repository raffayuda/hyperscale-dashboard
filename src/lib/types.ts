export type ProjectStatus = 'Ready' | 'Building' | 'Error';

export interface Project {
    id: string;
    slug: string;
    name: string;
    url: string;
    status: ProjectStatus;
    githubRepo?: string;
    branch: string;
    updatedAt: string;
    updatedAtHuman: string;
    previewImage?: string;
    lastCommit?: string;
}

export interface Repository {
    id: number;
    name: string;
    fullName: string;
    updated: string;
    url: string;
}

export interface TemplateProject {
    id: number;
    name: string;
    description: string;
    icon: string;
}

export interface DeploymentProjectRef {
    id: string;
    slug: string;
    name: string;
}

export interface Deployment {
    id: string;
    deploymentId: string;
    status: ProjectStatus | 'Building' | 'Error';
    environment: string;
    branch: string;
    commitHash: string;
    commitMessage: string;
    author: string;
    deployedAt: string;
    deployedAtHuman: string;
    timeFormatted: string;
    isCurrent: boolean;
    project: DeploymentProjectRef;
}

export interface Database {
    id: string;
    name: string;
    type: string;
    region: string;
    status: 'active' | 'provisioning';
    storageSize: number;
    autoBackup: boolean;
    host: string;
    port: number;
    username: string;
    password: string;
    connectionString: string;
}

export interface EnvVar {
    key: string;
    value: string;
}

export interface NewProjectForm {
    name: string;
    gitUrl: string;
    framework: string;
    rootDir: string;
    buildCommand: string;
    outputDir: string;
    envVars: EnvVar[];
}

export interface NewDatabaseForm {
    name: string;
    type: string;
    region: string;
    connectionLimit: number;
    storageSize: number;
    autoBackup: boolean;
    envVars: EnvVar[];
}


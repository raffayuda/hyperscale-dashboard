const projects = [
  {
    id: "proj-1",
    slug: "machine-learning",
    name: "Machine Learning",
    url: "ml.hyperscale.dev",
    status: "Ready",
    githubRepo: "raffayuda/Machine-Learning",
    branch: "main",
    updatedAt: "2025-11-21T06:50:00Z",
    updatedAtHuman: "2h ago",
    lastCommit: "feat: add vector db sync",
    previewImage: ""
  },
  {
    id: "proj-2",
    slug: "pemesanan-tiket-bioskop",
    name: "Pemesanan Tiket Bioskop",
    url: "bioskop.hyperscale.dev",
    status: "Ready",
    githubRepo: "raffayuda/Pemesanan-tiket-bioskop",
    branch: "main",
    updatedAt: "2025-11-20T11:32:00Z",
    updatedAtHuman: "23h ago",
    lastCommit: "chore: bump runtime deps",
    previewImage: ""
  },
  {
    id: "proj-3",
    slug: "information-retrieval",
    name: "Information Retrieval",
    url: "ir.hyperscale.dev",
    status: "Building",
    githubRepo: "raffayuda/Information-retrieval",
    branch: "develop",
    updatedAt: "2025-11-21T04:05:00Z",
    updatedAtHuman: "5h ago",
    lastCommit: "refactor: search indexing",
    previewImage: ""
  },
  {
    id: "proj-4",
    slug: "hyperscale-kwu",
    name: "Hyperscale KWU",
    url: "kwu.hyperscale.dev",
    status: "Ready",
    githubRepo: "raffayuda/hyperscale-KWU",
    branch: "main",
    updatedAt: "2025-11-18T08:15:00Z",
    updatedAtHuman: "3d ago",
    lastCommit: "feat: add billing settings",
    previewImage: ""
  }
];
const deployments = [
  {
    id: "dep-01",
    deploymentId: "dpl_78312",
    status: "Ready",
    environment: "Production",
    branch: "main",
    commitHash: "14ac9d8",
    commitMessage: "feat: add vector db sync",
    author: "raffayuda",
    deployedAt: "2025-11-21T06:50:00Z",
    deployedAtHuman: "2 hours ago",
    timeFormatted: "13:50",
    isCurrent: true,
    project: { id: "proj-1", slug: "machine-learning", name: "Machine Learning" }
  },
  {
    id: "dep-02",
    deploymentId: "dpl_78298",
    status: "Ready",
    environment: "Preview",
    branch: "feature/ab-test",
    commitHash: "6bdc908",
    commitMessage: "test: add new hero copy",
    author: "adeline",
    deployedAt: "2025-11-21T03:22:00Z",
    deployedAtHuman: "5 hours ago",
    timeFormatted: "10:22",
    isCurrent: false,
    project: { id: "proj-2", slug: "pemesanan-tiket-bioskop", name: "Pemesanan Tiket Bioskop" }
  },
  {
    id: "dep-03",
    deploymentId: "dpl_78265",
    status: "Building",
    environment: "Production",
    branch: "develop",
    commitHash: "b11a3ce",
    commitMessage: "refactor: search indexing",
    author: "mia",
    deployedAt: "2025-11-20T21:05:00Z",
    deployedAtHuman: "11 hours ago",
    timeFormatted: "04:05",
    isCurrent: false,
    project: { id: "proj-3", slug: "information-retrieval", name: "Information Retrieval" }
  },
  {
    id: "dep-04",
    deploymentId: "dpl_78110",
    status: "Error",
    environment: "Preview",
    branch: "feature/payments",
    commitHash: "c31090f",
    commitMessage: "feat: add billing settings",
    author: "raffayuda",
    deployedAt: "2025-11-19T14:40:00Z",
    deployedAtHuman: "1 day ago",
    timeFormatted: "21:40",
    isCurrent: false,
    project: { id: "proj-4", slug: "hyperscale-kwu", name: "Hyperscale KWU" }
  }
];
const databases = [
  {
    id: "db-01",
    name: "ml-core-db",
    type: "PostgreSQL",
    region: "US East (N. Virginia)",
    status: "active",
    storageSize: 32,
    autoBackup: true,
    host: "ml-core-db.hyperscale.dev",
    port: 5432,
    username: "admin_ml",
    password: "secure-ml-pass",
    connectionString: "postgres://admin_ml:secure-ml-pass@ml-core-db.hyperscale.dev:5432/ml_core"
  },
  {
    id: "db-02",
    name: "bioskop-orders",
    type: "MySQL",
    region: "Asia Pacific (Singapore)",
    status: "active",
    storageSize: 64,
    autoBackup: true,
    host: "bioskop-orders.hyperscale.dev",
    port: 3306,
    username: "orders_admin",
    password: "orders-secret",
    connectionString: "mysql://orders_admin:orders-secret@bioskop-orders.hyperscale.dev:3306/orders"
  },
  {
    id: "db-03",
    name: "ir-cache",
    type: "Redis",
    region: "Asia Pacific (Tokyo)",
    status: "provisioning",
    storageSize: 8,
    autoBackup: false,
    host: "ir-cache.hyperscale.dev",
    port: 6379,
    username: "cache",
    password: "redis-pass",
    connectionString: "redis://cache:redis-pass@ir-cache.hyperscale.dev:6379"
  }
];
export {
  databases as a,
  deployments as d,
  projects as p
};

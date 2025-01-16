<?php

use PHPUnit\Framework\TestCase;

class RelacionamentoTest extends TestCase
{
    private $relacionamentoService;
    private $db;

    protected function setUp(): void
    {
        // Configuração do banco de dados fictício ou mock
        $this->db = new PDO('sqlite::memory:');
        $this->db->exec("CREATE TABLE influenciadores (id INTEGER PRIMARY KEY, nome TEXT, usuario_instagram TEXT UNIQUE, seguidores INTEGER, categoria TEXT)");
        $this->db->exec("CREATE TABLE campanhas (id INTEGER PRIMARY KEY, nome TEXT, orcamento DECIMAL, descricao TEXT, data_inicio DATETIME, data_fim DATETIME)");
        $this->db->exec("CREATE TABLE influenciador_campanha (id_influenciador INTEGER, id_campanha INTEGER, PRIMARY KEY(id_influenciador, id_campanha))");

        $this->relacionamentoService = new RelacionamentoService($this->db);
    }

    public function testRelacionarInfluenciadorComCampanha()
    {
        // Criação de influenciador e campanha
        $this->db->exec("INSERT INTO influenciadores (nome, usuario_instagram, seguidores, categoria) VALUES ('João Silva', 'joao_instagram', 5000, 'Tecnologia')");
        $this->db->exec("INSERT INTO campanhas (nome, orcamento, descricao, data_inicio, data_fim) VALUES ('Campanha de Tecnologia', 10000.50, 'Campanha de tecnologia', '2025-02-01', '2025-02-28')");

        // Relacionando influenciador à campanha
        $resultado = $this->relacionamentoService->relacionarInfluenciadorComCampanha(1, 1);
        $this->assertTrue($resultado);

        // Verificando se o relacionamento foi criado
        $stmt = $this->db->query("SELECT * FROM influenciador_campanha WHERE id_influenciador = 1 AND id_campanha = 1");
        $relacionamento = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotEmpty($relacionamento);
    }

    public function testRelacionamentoDuplicado()
    {
        // Tentando relacionar o mesmo influenciador à mesma campanha
        $this->db->exec("INSERT INTO influenciadores (nome, usuario_instagram, seguidores, categoria) VALUES ('Carlos Silva', 'carlos_instagram', 3000, 'Beleza')");
        $this->db->exec("INSERT INTO campanhas (nome, orcamento, descricao, data_inicio, data_fim) VALUES ('Campanha de Beleza', 5000.00, 'Campanha de beleza', '2025-03-01', '2025-03-10')");

        $this->relacionamentoService->relacionarInfluenciadorComCampanha(2, 2);
        $resultado = $this->relacionamentoService->relacionarInfluenciadorComCampanha(2, 2);

        $this->assertFalse($resultado); // Espera-se falha devido a relacionamento duplicado
    }
}

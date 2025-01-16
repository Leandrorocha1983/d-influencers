<?php

use PHPUnit\Framework\TestCase;

class CampanhaTest extends TestCase
{
    private $campanhaService;
    private $db;

    protected function setUp(): void
    {
        // Configuração do banco de dados fictício ou mock
        $this->db = new PDO('sqlite::memory:');
        $this->db->exec("CREATE TABLE campanhas (id INTEGER PRIMARY KEY, nome TEXT, orcamento DECIMAL, descricao TEXT, data_inicio DATETIME, data_fim DATETIME)");

        $this->campanhaService = new CampanhaService($this->db);
    }

    public function testCriarCampanha()
    {
        // Teste de criação de campanha
        $resultado = $this->campanhaService->criarCampanha('Campanha de Tecnologia', 10000.50, 'Campanha de tecnologia inovadora', '2025-02-01', '2025-02-28');
        $this->assertTrue($resultado);

        // Verificando se a campanha foi criada
        $stmt = $this->db->query("SELECT * FROM campanhas WHERE nome = 'Campanha de Tecnologia'");
        $campanha = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotEmpty($campanha);
        $this->assertEquals('Campanha de Tecnologia', $campanha['nome']);
    }

    public function testOrcamentoPositivo()
    {
        // Teste para verificar se o orçamento é positivo
        $resultado = $this->campanhaService->criarCampanha('Campanha de Beleza', -1000, 'Campanha de beleza', '2025-03-01', '2025-03-10');
        $this->assertFalse($resultado); // Espera-se falha devido ao orçamento negativo
    }

    public function testCamposObrigatorios()
    {
        // Teste para verificar se os campos obrigatórios são validados
        $resultado = $this->campanhaService->criarCampanha('', -1000, '', '', '');
        $this->assertFalse($resultado); // Espera-se falha devido a campos inválidos
    }
}

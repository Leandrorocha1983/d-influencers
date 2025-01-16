<?php

use PHPUnit\Framework\TestCase;

class InfluenciadorTest extends TestCase
{
    private $influenciadorService;
    private $db;

    protected function setUp(): void
    {
        // Configuração do banco de dados fictício ou mock
        $this->db = new PDO('sqlite::memory:');
        $this->db->exec("CREATE TABLE influenciadores (id INTEGER PRIMARY KEY, nome TEXT, usuario_instagram TEXT UNIQUE, seguidores INTEGER, categoria TEXT)");

        $this->influenciadorService = new InfluenciadorService($this->db);
    }

    public function testCriarInfluenciador()
    {
        // Teste de criação de influenciador
        $resultado = $this->influenciadorService->criarInfluenciador('João Silva', 'joao_instagram', 5000, 'Tecnologia');
        $this->assertTrue($resultado);

        // Verificando se o influenciador foi criado
        $stmt = $this->db->query("SELECT * FROM influenciadores WHERE usuario_instagram = 'joao_instagram'");
        $influenciador = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotEmpty($influenciador);
        $this->assertEquals('João Silva', $influenciador['nome']);
    }

    public function testUsuarioInstagramUnico()
    {
        // Tentando criar dois influenciadores com o mesmo Instagram
        $this->influenciadorService->criarInfluenciador('João Silva', 'joao_instagram', 5000, 'Tecnologia');
        $resultado = $this->influenciadorService->criarInfluenciador('Carlos Silva', 'joao_instagram', 3000, 'Beleza');

        $this->assertFalse($resultado); // Espera-se falha devido à unicidade do Instagram
    }

    public function testCamposObrigatorios()
    {
        // Teste para verificar se os campos obrigatórios são validados
        $resultado = $this->influenciadorService->criarInfluenciador('', '', -5000, '');
        $this->assertFalse($resultado); // Espera-se falha devido a campos inválidos
    }
}

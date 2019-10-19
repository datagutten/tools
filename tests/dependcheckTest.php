<?php


use PHPUnit\Framework\TestCase;

class dependcheckTest extends TestCase
{

    /**
     * @doesNotPerformAssertions
     */
    public function testDepend()
    {
        $dependcheck = new dependcheck();
        $dependcheck->depend('ffmpeg');
    }

    public function testDependFail()
    {
        $this->expectException(DependencyFailedException::class);
        $dependcheck = new dependcheck();
        $dependcheck->depend('ffmpegXXX');
    }

    public function testSelect_tool()
    {
        $dependcheck = new dependcheck();
        $tool = $dependcheck->select_tool(['XXX', 'ffmpeg']);
        $this->assertSame('ffmpeg', $tool);
    }

    public function testNoToolsFound()
    {
        $this->expectException(DependencyFailedException::class);
        $this->expectExceptionMessage('No valid tools found');
        $dependcheck = new dependcheck();
        $dependcheck->select_tool(['XXX', 'XXXX']);
    }
}
